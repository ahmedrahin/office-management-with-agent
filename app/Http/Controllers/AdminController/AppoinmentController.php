<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Employees;

class AppoinmentController extends Controller
{
    public function manage($year = null, $month = null)
    {
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

        // Count task statuses
        $pendingCount = $data->where('status', 'pending')->count();
        $reScheduleCount = $data->where('status', 're-schedule')->count();
        $completeCount = $data->where('status', 'complete')->count();

        return view('backend.pages.appoinment.manage', compact('data', 'allYear', 'selectedDate', 'pendingCount', 'reScheduleCount', 'completeCount'));
    }


    public function today()
    {
        $today = Carbon::now()->format('d M, Y');

        $data = Task::where('date', $today)
                    ->latest()
                    ->get();

        return view('backend.pages.task.today', compact('data'));
    }

    public function week()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('d M, Y');
        $endOfWeek = Carbon::now()->endOfWeek()->format('d M, Y');

        // Fetch tasks within the current week range
        $data = Task::where('date', '>=', $startOfWeek)
                    ->where('date', '<=', $endOfWeek)
                    ->orderBy('date', 'asc')
                    ->get();

        return view('backend.pages.task.week', compact('data'));
    }


    public function create(){
        $employees = Employees::orderBy('name', 'asc')->get();
        return view('backend.pages.task.add', compact('employees'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'start_time' => 'nullable',
        //     'emp' => 'required',
        //     'task' => 'required',
        //     'date' => 'required|after_or_equal:today',
        // ]);

        $date = Carbon::createFromFormat('d M, Y', $request->date);
        $month = $date->format('M');
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
         $data->date = Carbon::parse($data->date)->format('d M, Y');
        return view('backend.pages.task.edit', compact('data','employees'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => 'required',
            'emp' => 'required',
            'date' => 'required|after_or_equal:today',
        ]);

        $task = Task::findOrFail($id);
        $task->tasks = $request->task;
        $task->employees_id = $request->emp;
        $task->date = Carbon::parse($request->date)->format('d M, Y');
        $task->month = Carbon::parse($request->date)->format('M');
        $task->year = Carbon::parse($request->date)->format('Y');
        $task->time = $request->start_time;
        $task->note = $request->note;
        $task->status = $request->status;
        $task->save();

         return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!'
        ]);
    }

    public function show($id){

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


    public function myTasks($id)
    {
        $filter = request('filter', 'today');
        $tasks = Task::where('employees_id', $id);

        switch ($filter) {
            case 'today':
                $today = Carbon::today()->format('d M, Y');
                $tasks->where('date', $today);
                $filterTitle = 'Today';
                break;

            case 'week':
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();
                $datesInWeek = collect();

                // Generate all dates in the week
                for ($date = $startOfWeek; $date <= $endOfWeek; $date->addDay()) {
                    $datesInWeek->push($date->format('d M, Y'));
                }

                $tasks->whereIn('date', $datesInWeek->toArray());
                $filterTitle = 'This Week';
                break;

            case 'month':
                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');
                $tasks->where('month', $month)->where('year', $year);
                $filterTitle = 'This Month';
                break;

            default:
                $filterTitle = 'All';
                break;
        }

        $data = $tasks->latest()->get();
        $pendingCount = $data->where('status', 'pending')->count();
        $reScheduleCount = $data->where('status', 're-schedule')->count();
        $completeCount = $data->where('status', 'complete')->count();

        return view('backend.pages.task.my-tasks', compact('data', 'pendingCount', 'reScheduleCount', 'completeCount', 'filterTitle'));
    }


    public function updateStatus(Request $request)
    {

        $task = Task::find($request->id);
        $task->status = $request->status;

        if ($task->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update status']);
        }
    }



}
