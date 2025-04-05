<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salarie;
use App\Models\Employees;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\AdvanceSalary;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($year = null, $month = null)
    {
        $year = $year ?? date('Y');
        $month = $month ?? Carbon::now()->format('M'); 

        // Fetch employees along with their salary records for the specified month and year
        $employees = DB::table('employees')
                    ->leftJoin('salaries', function ($join) use ($year, $month) {
                        $join->on('employees.id', '=', 'salaries.employees_id')
                            ->where('salaries.salary_year', $year)
                            ->where('salaries.salary_month', $month);
                    })
                    ->leftJoin('attendances', function ($join) use ($year, $month) {
                        $join->on('employees.id', '=', 'attendances.emp_id')
                            ->where('attendances.att_year', $year)
                            ->where('attendances.month', $month)
                            ->where('attendances.att', 'absence');
                    })
                    ->select(
                        'employees.id',
                        'employees.name',
                        'employees.image',
                        'employees.join_date',
                        'employees.salary as basic_salary',
                        'salaries.due',
                        'salaries.cut_salary',
                        'salaries.adv_salary',
                        'salaries.salary_note',
                        'salaries.bonus',
                        'employees.position',
                        'employees.employee_office_id',
                        'employees.created_at',
                        'salaries.salary',
                        'salaries.salary_month',
                        'salaries.salary_year',
                        'salaries.created_at as salary_issue_date',
                        'salaries.description',
                        'salaries.id as salary_id',
                        DB::raw('COUNT(attendances.id) as absences') // Aggregated column
                    )
                    ->groupBy(
                        'employees.id',
                        'employees.name',
                        'employees.image',
                        'employees.salary',
                        'employees.position',
                        'employees.employee_office_id',
                        'employees.join_date',
                        'employees.created_at',
                        'salaries.salary',
                        'salaries.salary_month',
                        'salaries.salary_year',
                        'salaries.created_at',
                        'salaries.description',
                        'salaries.id',
                        'salaries.due',
                        'salaries.cut_salary',
                        'salaries.adv_salary',
                        'salaries.salary_note',  // Added missing column
                        'salaries.bonus'         // Added missing column
                    )
                    ->get();

        // Get all distinct years from salary records
        $allYear = DB::table('salaries')
                    ->select('salary_year')
                    ->distinct()
                    ->orderBy('salary_year', 'desc')
                    ->pluck('salary_year');

        return view('backend.pages.salaries.list', compact('employees', 'year', 'month', 'allYear'));
    }

    public function create($id, $year = null, $month = null)
    {   
        $year = $year ?? date('Y');
        $month = $month ?? date('M');

        $employee = Employees::with([
            'salaries',
            'attendance' => function ($query) use ($year, $month) {
                $query->where('att_year', $year)
                    ->where('month', $month)
                    ->where('att', 'absence');
            }
        ])->find($id);

        return view('backend.pages.salaries.pay', compact('employee', 'year', 'month'));
    }

    public function edit($id){

    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request
        $request->validate([
            'employees_id' => 'required|exists:employees,id', 
            'salary' => 'required|numeric|min:0',
            'date' => 'required|date_format:F Y', 
            'bonus' => 'nullable|numeric|min:1',
            'due' => ['nullable', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($value > $request->salary) {
                    $fail('The due amount cannot be greater than the salary.');
                }
            }]
        ], [
            'employees_id.required' => 'Please select an employee.',
            'employees_id.exists' => 'The selected employee does not exist.',
            'salary.required' => 'Please enter the salary amount.',
            'salary.numeric' => 'Salary must be a valid number.',
            'salary.min' => 'Salary must be greater than or equal 0.',
            'date.required' => 'Please select a date.',
            'date.date_format' => 'Date format should be "Month Year".',
        ]);

        // Extract Month and Year from date
        $month = date('M', strtotime($request->date)); 
        $year = date('Y', strtotime($request->date)); 

        // Ensure the selected month is not in the future
        $currentMonth = date('M');
        $currentYear = date('Y');

        $existingSalary = Salarie::where('employees_id', $request->employees_id)
            ->where('salary_month', $month)
            ->where('salary_year', $year)
            ->exists();

        if ($existingSalary) {
            return back()->withErrors(['date' => 'Salary for this employee has already been paid for this month/year.'])->withInput();
        }

        if (strtotime($request->date) > strtotime("$currentMonth $currentYear")) {
            return back()->withErrors(['date' => 'Salary payment cannot be for a future month.'])->withInput();
        }

        // Fetch the employee's actual salary
        $employee = Employees::find($request->employees_id);
        if (!$employee) {
            return back()->withErrors(['employees_id' => 'Invalid Employee selected.'])->withInput();
        }

        // Check if salary amount exceeds employee's salary
        if ($request->salary > $employee->salary) {
            return back()->withErrors(['salary' => 'Salary amount cannot exceed employee’s actual salary.'])->withInput();
        }

        $paidTotal = $request->salary + $request->bonus;
        $cut = $employee->salary - $request->salary - $request->due - $request->adv_salary ?? null ;

        // Store Salary Payment
        $data = Salarie::create([
            'employees_id' => $request->employees_id,
            'salary' => $paidTotal,
            'salary_month' => $month,  
            'salary_year' => $year,    
            'salary_date' => $request->date,
            'description' => $request->details,
            'bonus' => $request->bonus,
            'due' => $request->due,
            'salary_note' => $request->salary_note,
            'cut_salary' => $cut ?? null,
            'adv_salary' => $request->adv_salary ?? null,
            'adv_percent' => $request->adv_percent ?? null,
        ]);

        return redirect()->route('pay.list',[$data->salary_year, $data->salary_month])->with('success', 'Salary paid successfully!');
    }


    public function delete(string $id)
    {
        $delete = Salarie::find($id)->delete();
    }

    public function custom(){
        $employees = Employees::orderBy('name', 'asc')->get();
        return view('backend.pages.salaries.pay-custom', compact('employees'));
    }

    public function adv(){
        $employees = Employees::orderBy('name', 'asc')->get();
        return view('backend.pages.salaries.pay-adv', compact('employees'));
    }

    public function paidadv(Request $request){
        // Validate the request
        $request->validate([
            'employees_id' => 'required|exists:employees,id', 
            'salary' => 'required|numeric|min:1',
            'date' => 'required|date_format:F Y', 
        ], [
            'employees_id.required' => 'Please select an employee.',
            'employees_id.exists' => 'The selected employee does not exist.',
            'salary.required' => 'Please enter the salary amount.',
            'salary.numeric' => 'Salary must be a valid number.',
            'salary.min' => 'Salary must be greater than 0.',
            'date.required' => 'Please select a date.',
            'date.date_format' => 'Date format should be "Month Year".',
        ]);

        // Extract Month and Year from date
        $month = date('M', strtotime($request->date)); 
        $year = date('Y', strtotime($request->date)); 

        // Ensure the selected month is not in the future
        $currentMonth = date('M');
        $currentYear = date('Y');

        $existingSalary = AdvanceSalary::where('employees_id', $request->employees_id)
            ->where('salary_month', $month)
            ->where('salary_year', $year)
            ->exists();

        if ($existingSalary) {
            return back()->withErrors(['date' => 'Advance Salary for this employee has already been paid for this month/year.'])->withInput();
        }

        if (strtotime($request->date) < strtotime("$currentMonth $currentYear")) {
            return back()->withErrors(['date' => 'Advance salary can not able for previouse months'])->withInput();
        }

        // Fetch the employee's actual salary
        $employee = Employees::find($request->employees_id);
        if (!$employee) {
            return back()->withErrors(['employees_id' => 'Invalid Employee selected.'])->withInput();
        }

        // Check if salary amount exceeds employee's salary
        if ($request->salary > $employee->salary) {
            return back()->withErrors(['salary' => 'Salary amount cannot exceed employee’s actual salary.'])->withInput();
        }

        // Store Salary Payment
        $data = AdvanceSalary::create([
            'employees_id' => $request->employees_id,
            'adv_salary' => $request->salary,
            'salary_month' => $month,  
            'salary_year' => $year,    
            'salary_date' => $request->date,
            'description' => $request->details,
        ]);

        return redirect()->route('pay.list',[$data->salary_year, $data->salary_month])->with('success', 'Advance salary paid successfully!');
    }

    public function details($id, $year = null, $month = null){
        $year = $year ?? date('Y');
        $month = $month ?? date('M');

        $employee = Employees::with([
            'salaries' => function ($query) use ($year, $month) {
                $query->where('salary_year', $year)
                    ->where('salary_month', $month);
            },
            'attendance' => function ($query) use ($year, $month) {
                $query->where('att_year', $year)
                    ->where('month', $month)
                    ->where('att', 'absence');
            }
        ])->find($id);

        return view('backend.pages.salaries.details', compact('employee', 'year', 'month'));
    }

    public function listadv() {
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->format('M'); // "Mar"
    
        $data = AdvanceSalary::where(function ($query) use ($currentYear, $currentMonth) {
            $query->where('salary_year', '>=', $currentYear) // Future years
                  ->orWhere(function ($query) use ($currentYear, $currentMonth) {
                      $query->whereRaw("STR_TO_DATE(salary_month, '%b') >= STR_TO_DATE(?, '%b')", [$currentMonth]);
                  });
        })->get();
    
        return view('backend.pages.salaries.adv-list', compact('data'));
    }
    
    
    

    public function editadv($id){
        $data = AdvanceSalary::where('id',$id)->first();
        return view('backend.pages.salaries.editadv', compact('data'));
    }

    public function updateadv(Request $request, int $id){

        $update = AdvanceSalary::find($id);

        $request->validate([
            'salary' => 'required|numeric|min:1',
            'date' => 'required|date_format:F Y', 
        ], [
            'salary.required' => 'Please enter the salary amount.',
            'salary.numeric' => 'Salary must be a valid number.',
            'salary.min' => 'Salary must be greater than 0.',
            'date.required' => 'Please select a date.',
            'date.date_format' => 'Date format should be "Month Year".',
        ]);

        if ($request->salary > $update->employees->salary) {
            return back()->withErrors(['salary' => 'Salary amount cannot exceed employee’s actual salary.'])->withInput();
        }

        $month = date('M', strtotime($request->date)); 
        $year = date('Y', strtotime($request->date)); 

        $currentMonth = date('M');
        $currentYear = date('Y');

        if (strtotime($request->date) < strtotime("$currentMonth $currentYear")) {
            return back()->withErrors(['date' => 'Advance salary can not able for previouse months'])->withInput();
        }

        $update->adv_salary = $request->salary;
        $update->salary_date = $request->date;
        $update->description = $request->details;
        $update->salary_month = $month;
        $update->salary_year = $year;
        $update->save();

        return redirect()->route('list.adv')->with('success', 'Advance salary paid successfully!');
    }
}
