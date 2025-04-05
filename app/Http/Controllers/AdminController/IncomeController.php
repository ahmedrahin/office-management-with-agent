<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use File;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {   
        $incomes = Income::all();
        return view('backend.pages.income.manage', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.income.add');
    }

    // today expense
    public function today()
    {   
        $today    = Carbon::now()->format('d M, Y');
        $incomes = Income::where('date', $today)->get();
        return view('backend.pages.income.today', compact('incomes'));
    }

     // month expense
     public function month()
     {   
         $month        = Carbon::now()->format('n');
         $monthname    = Carbon::now()->format('M');
         $year         = Carbon::now()->format('Y');
         $date         = null;
         $expenses     = Income::where('month', $month)->where('year', $year)->get();
         return view('backend.pages.income.month', compact('expenses', 'year', 'monthname', 'date'));
     }

     // year expense
     public function year()
     {   
         $year     = Carbon::now()->format('Y');
         $expenses = Income::where('year', $year)->get();
         $allYear = Income::select('year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
     
         return view('backend.pages.income.year', compact('expenses', 'year', 'allYear'));
     }

     public function yearFilter(Request $request){
        $year = $request->year;
        $expenses = Income::where('year', $request->year)->get();
        $allYear = Income::select('year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
        return view('backend.pages.income.year', compact('expenses', 'year', 'allYear'));
     }

     // monthly expenses
     public function monthlyIncome($month)
     {     
        $monthName = [
            'jan' => 1,
            'feb' => 2,
            'mar' => 3,
            'apr' => 4,
            'may' => 5,
            'jun' => 6,
            'jul' => 7,
            'aug' => 8,
            'sep' => 9,
            'oct' => 10,
            'nov' => 11,
            'dec' => 12,
        ];

        // $theMonth = array_flip($monthName);

        $year = Carbon::now()->format('Y');
        $isMonth = Carbon::now()->format('y');
        $getMonth = ucfirst($month). "-" .$isMonth;
        $theMonth = ucfirst($month);
        $date     = null;
        $expenses = Expense::where('month', '=', $monthName[$month])->where('year', $year)->get();

        return view('backend.pages.income.month', ['expenses' => $expenses, 'year' => $year, 'getMonth' => $getMonth, 'theMonth' => $theMonth, 'date' => $date]);
     }

     // monthlyDayExpenses expenses
     public function monthlyDayIncome(Request $request)
     {     
        $date     = $request->input('date');
        $year     = $request->input('year');
        $getMonth = date('d-M', strtotime($date));
        $theMonth = date('M', strtotime($date));
  
        $expenses = Expense::where('date', $date)->get();
         return view('backend.pages.expenses.month', ['expenses' => $expenses, 'year' => $year, 'getMonth' => $getMonth, 'theMonth' => $theMonth, 'date' => $date]);
     }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            "amn"   => "required|numeric",
            'month' => 'required',
            'year'  => 'required',
            'name'  => 'required'
        ],[
            'amn.required' => 'Enter a amount'
        ]);

        $data = new Income();

        // image 
        if ($request->image) {
            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->save(base_path('public/backend/images/expense/' . $name_gan));

            $data->image = 'backend/images/expense/' . $name_gan;
        }

        $data->amn         = $request->amn;
        $data->name        = $request->name;
        $data->month       = $request->month;
        $data->date        = $request->date ?? Carbon::now()->format('d M, Y');
        $data->details     = $request->details;
        $data->year        = $request->year;
        $data->user_id     = Auth::id();
        // save
        $data->save();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Income::find($id);
        $editData = Income::where('id', $edit->id)->first();
        return view('backend.pages.income.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $update = Income::find($id);
        // validation
        $request->validate([
            "amn"   => "required|numeric",
            'month' => 'required',
            'date'  => 'required',
            'year'  => 'required',
            'name'  => 'required'
        ],);

         // image 
         if($request->hasRemove){
            // delete employee image
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $update->image = null;
        }
        elseif ($request->image) {
            // delete employee image
            if (File::exists($update->image)) {
                File::delete($update->image);
            }

            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->save(base_path('public/backend/images/expense/' . $name_gan));

            $update->image = 'backend/images/expense/' . $name_gan;
        }

        $update->amn         = $request->amn;
        $update->month       = $request->month;
        $update->date        = $request->date;
        $update->details     = $request->details;
        $update->year        = $request->year;
        $update->name        = $request->name;
        // save
        $update->save();
    }

    public function show(string $id){
        $Income = Income::find($id);
        return view('backend.pages.income.show', compact('Income'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Income::find($id);
        if ($delete) {
            if (File::exists($delete->image)) {
                File::delete($delete->image);
            }
            $delete->delete();
        } else {
            return response()->json(['error' => 'Income not found.'], 404);
        }
    }
}
