<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage($year = null, $month = null)
    {
        // Default to the current year if not provided
        $year = $year ?? date('Y');
        // Default to the current month if not provided
        $month = $month ?? Carbon::now()->format('M'); 

        // Query the attendances for the selected year and month
        $attendances = DB::table('attendances')
            ->select(
                DB::raw('MAX(id) as id'),
                'att_date', 
                'att_year', 
                DB::raw('MAX(edit_date) as edit_date'),
                DB::raw('SUM(CASE WHEN att = "absence" THEN 1 ELSE 0 END) as absence_count'),
                DB::raw('SUM(CASE WHEN att = "present" THEN 1 ELSE 0 END) as present_count'),
                DB::raw('MAX(is_holiday) as is_holiday') 
            )
            ->where('att_year', $year) 
            ->where('month', $month)  
            ->groupBy('att_date', 'att_year')
            ->orderBy('att_date', 'desc')
            ->get();

        // Get the distinct years for the year filter dropdown
        $allYear = DB::table('attendances')
            ->select('att_year')
            ->distinct()
            ->orderBy('att_year', 'desc')
            ->pluck('att_year');

        // Return the data to the view
        return view('backend.pages.attendence.manage', compact('attendances', 'year', 'month', 'allYear'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function take()
    {   
        $employees = Employees::orderBy('name', 'asc')->get();
        $date = today()->format('d M, Y');
        $att_date = Attendance::where('att_date', $date)->first();
        return view('backend.pages.attendence.take', compact('employees', 'att_date', 'date'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            "date"  => "required",
            'year'  => 'required',
            'emp.*' => 'required',
            'att'   => 'required',
        ], [
            'att.required' => 'please select all employee attendance'
        ]);

        // condition
        $date = $request->date;
        $att_date = Attendance::where('att_date', $date)->first();
        if($att_date){
            return response()->json(['error' => 'Today Attendance Already Taken'], 422);
        }else{
            foreach($request->emp as $employeeId){
                $attendance = new Attendance();
                $attendance->emp_id     = $employeeId;
                $attendance->att_date   = $request->date;
                $attendance->att_year   = $request->year;
                $attendance->att        = $request->att[$employeeId];
                $attendance->edit_date  = date("d_m_y");
                $attendance->month      = date("M");
                $attendance->is_holiday = $request->holiday ?? 0;
                $attendance->save();
            }  
        }
           
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $edit_date)
    {   
        $edit_date_time = $edit_date;
        $editData = Attendance::where('edit_date', $edit_date_time)->get();
        $is_holiday = $editData->contains('is_holiday', 1);
        
        return view('backend.pages.attendence.edit', compact('editData', 'edit_date_time'));
    }

    public function month_attendance($year = null, $month = null)
    {   
        // Set default year and month if not provided
        $year = $year ?? date('Y');
        $month = $month ?? (Carbon::now()->format('M')); 
        
        // Check if attendance exists for the selected month and year
        $isMonthExists = DB::table('attendances')
                            ->where('month', $month)
                            ->where('att_year', $year)
                            ->exists();
        
        // Format the month-year string for display (e.g., Jan-2025)
        $getMonth = ucfirst($month) . "-" . $year; 
        
        // Fetch employees ordered by name
        $employees = Employees::orderBy('name', 'asc')->get();
        
        // Get available years for filtering
        $allYear = DB::table('attendances')
                        ->select('att_year')
                        ->distinct()
                        ->orderBy('att_year', 'desc')
                        ->pluck('att_year');
        
        // Return the view with the necessary data
        return view('backend.pages.attendence.monthly-attendance', compact('employees', 'month', 'getMonth', 'isMonthExists', 'allYear', 'year'));
    }
    

    public function monthly_attendance($month, Request $request)
    {
        $year = $request->get('year', date('Y')); 
        $month = ucfirst($month); 
    
        $isMonthExists = DB::table('attendances')
            ->where('month', $month)
            ->where('att_year', $year)
            ->exists();
        
        // Get the month-year string for display
        $getMonth = $month . "-" . $year;
    
        // Fetch employees
        $employees = Employees::orderBy('name', 'asc')->get();
    
        // Fetch all distinct years for filtering
        $allYear = DB::table('attendances')
            ->select('att_year')
            ->distinct()
            ->orderBy('att_year', 'desc')
            ->pluck('att_year');
    
        return view('backend.pages.attendence.monthly-attendance', compact('employees', 'month', 'getMonth', 'isMonthExists', 'allYear', 'year'));
    }

    public function details($employee_id, $month, $year)
    {
        // Fetch attendance records for the given employee, month, and year
        $attendanceRecords = Attendance::where('emp_id', $employee_id)
            ->where('month', $month)
            ->where('att_year', $year)
            ->get();
    
        $employee = Employees::find($employee_id);
    
        // Get the total number of days in the month
        $totalDays = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($month . ' 1')), $year);
    
        // Initialize variables to count attendance types
        $totalPresent = 0;
        $totalAbsent = 0;
        $totalHoliday = 0;
    
        // Initialize the attendanceData array
        $attendanceData = [];
    
        foreach ($attendanceRecords as $attendance) {
            $day = (int) date('d', strtotime($attendance->att_date)); // Extract day from att_date
            $status = $attendance->att; // Attendance status (P = Present, A = Absent, H = Holiday)
    
            $attendanceData[$day] = [
                'day' => $day,
                'status' => $status,
            ];
    
            // Count the attendance types
            if ($status === 'present') {
                $totalPresent++;
            } elseif ($status === 'absence') {
                $totalAbsent++;
            } elseif ($status === 'holiday') {
                $totalHoliday++;
            }
        }
    
        // Fill in the rest of the days with 'not_taken' if no record exists
        for ($day = 1; $day <= $totalDays; $day++) {
            if (!isset($attendanceData[$day])) {
                $attendanceData[$day] = [
                    'day' => $day,
                    'status' => 'not_taken'
                ];
            }
        }
    
        return view('backend.pages.attendence.details', compact('employee', 'attendanceData', 'month', 'year', 'totalPresent', 'totalAbsent', 'totalHoliday'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $edit_date)
    {
        $updates  = Attendance::where('edit_date', $edit_date)->get();

        // validation
        $request->validate([
            'att'   => 'required',
        ]);

        foreach ($updates as $update) {
            $employeeId   = $update->emp_id;
            $update->att = $request->att[$employeeId];
            $update->is_holiday = $request->holiday ?? 0;
            $update->save();
        }
    }

    public function takecustom(){
        $employees = Employees::orderBy('name', 'asc')->get();
        $date = today()->format('d M, Y');
        $att_date = Attendance::where('att_date', $date)->first();
        return view('backend.pages.attendence.custom', compact('employees', 'att_date', 'date'));
    }

    public function takecustomstore(Request $request){

        $date = Carbon::createFromFormat('j M, Y', $request->date);

        if ($date->gt(Carbon::today())) {
            return response()->json(['error' => 'The date should not be later than today.'], 422);
        }

        $request->validate([
            "date" => "required",
            'emp.*' => 'required',
            'att'   => 'required',
        ], [
            'att.required' => 'Please select all employee attendance',
            'date.before_or_equal' => 'The date should not be later than today.',
        ]);
        

        $date = $request->date;
        $att_date = Attendance::where('att_date', $date)->first();
        if($att_date){
            return response()->json(['error' => 'Attendance Already Taken on this day'], 422);
        }else{

            $date = Carbon::createFromFormat('j M, Y', $request->date);
            $year = $date->format('Y');      
            $edit_date = $date->format('d_m_y'); 
            $month = $date->format('M'); 
            
            // dd($year);

            foreach($request->emp as $employeeId){
                $attendance = new Attendance();
                $attendance->emp_id     = $employeeId;
                $attendance->att_date   = $request->date;
                $attendance->att_year   = $year;
                $attendance->att        = $request->att[$employeeId];
                $attendance->edit_date  = $edit_date;
                $attendance->month      = $month;
                $attendance->is_holiday = $request->holiday ?? 0;
                $attendance->save();
            }  
        }
    }
}
