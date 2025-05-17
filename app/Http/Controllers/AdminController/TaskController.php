<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Employees;

class TaskController extends Controller
{
    public function manage($year = null, $month = null){
        $year = $year ?? date('Y');
        $month = $month ?? Carbon::now()->format('M'); 

        $selectedDate = ucfirst($month) . ' - ' . $year;

        $data = Task::with('employees')
                ->where('year', $year)
                ->where('month', $month)
                ->latest()
                ->get();

        $allYear = DB::table('tasks')
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');


        return view('backend.pages.task.manage', compact('data' , 'allYear', 'selectedDate'));
    }

    public function create(){
        $employees = Employees::orderBy('name', 'asc')->get();
        return view('backend.pages.task.add', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'nullable',
            'emp' => 'required',
            'task' => 'required',
            'date' => 'required|after_or_equal:today', 
        ]);

        $date = \Carbon\Carbon::createFromFormat('d M, Y', $request->date);
        $month = $date->format('F');
        $year = $date->format('Y'); 

        Task::create([
            'tasks' => $request->task,
            'date' => $request->date,
            'month' => $month,
            'year' => $year,
            'time' => $request->start_time,
            'status' => 'pending',
            'note' => $request->note,
            'employees_id' => $request->emp,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task added successfully!'
        ]);
    }

     public function edit($id){
        $data = Task::find($id);
        $employees = Employees::orderBy('name', 'asc')->get();
        return view('backend.pages.task.edit', compact('data','employees'));
    }



    public function destroy($id){
        $delete = Task::find($id);
        if ($delete) {
            $delete->delete();
            
            return response()->json([
                'message' => 'Task deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => ' not found.'], 404);
        }
    }

}
