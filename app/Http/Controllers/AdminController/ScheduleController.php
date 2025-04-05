<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(){
        $data = Schedule::orderBy('id', 'desc')->get();
        return view('backend.pages.shedule.manage', compact('data'));
    }

    public function store(Request $request) {
        // Clean the input times (add leading zero to single-digit hours, ensure lowercase AM/PM)
        $request->merge([
            'start_time' => preg_replace('/^(\d):/', '0$1:', strtolower($request->start_time)),
            'end_time' => preg_replace('/^(\d):/', '0$1:', strtolower($request->end_time)),
        ]);
        
        // Validate that the times are in correct format
        $request->validate([
            'name' => 'required|unique:schedules,name',
            'start_time' => 'required|date_format:h:i a',
            'end_time' => 'required|date_format:h:i a',
        ], [
            'start_time.date_format' => 'Start time must be in hh:mm AM/PM format.',
            'end_time.date_format' => 'End time must be in hh:mm AM/PM format.',
        ]);
    
        // Convert to Carbon instances after validation
        $startTime = Carbon::createFromFormat('h:i a', $request->start_time);
        $endTime = Carbon::createFromFormat('h:i a', $request->end_time);
    
        // Check if end_time is after start_time
        if ($endTime <= $startTime) {
            return response()->json([
                'errors' => [
                    'end_time' => ['End time must be greater than start time.']
                ]
            ], 422);
        }
    
        // Calculate total minutes & hours
        $totalMinutes = $startTime->diffInMinutes($endTime);
        $totalHours = floor($totalMinutes / 60);
        $remainingMinutes = $totalMinutes % 60;
        $totalTime = "{$totalHours} hours {$remainingMinutes} minutes";
    
        // Save the schedule to the database
        Schedule::create([
            'name' => $request->name,
            'start_time' => $startTime->format('h:i A'),
            'end_time' => $endTime->format('h:i A'),
            'total_minute' => $totalMinutes,
            'total_hourse' => $totalHours,
            'total_time' =>  $totalTime,
        ]);
    
        return response()->json(['success' => 'Schedule added successfully.']);
    }
    
    public function update(Request $request, $id)
    {
        // Find the schedule by ID
        $schedule = Schedule::findOrFail($id);

        // Clean the input times (add leading zero to single-digit hours, ensure lowercase AM/PM)
        $request->merge([
            'start_time' => preg_replace('/^(\d):/', '0$1:', strtolower($request->start_time)),
            'end_time' => preg_replace('/^(\d):/', '0$1:', strtolower($request->end_time)),
        ]);

        // Validate that the times are in correct format
        $request->validate([
            'name' => 'required|unique:schedules,name,' . $id,
            'start_time' => 'required|date_format:h:i a',
            'end_time' => 'required|date_format:h:i a',
        ], [
            'start_time.date_format' => 'Start time must be in hh:mm AM/PM format.',
            'end_time.date_format' => 'End time must be in hh:mm AM/PM format.',
        ]);

        // Convert to Carbon instances after validation
        $startTime = Carbon::createFromFormat('h:i a', $request->start_time);
        $endTime = Carbon::createFromFormat('h:i a', $request->end_time);

        // Check if end_time is after start_time
        if ($endTime <= $startTime) {
            return response()->json([
                'errors' => [
                    'end_time' => ['End time must be greater than start time.']
                ]
            ], 422);
        }

        // Calculate total minutes & hours
        $totalMinutes = $startTime->diffInMinutes($endTime);
        $totalHours = floor($totalMinutes / 60);
        $remainingMinutes = $totalMinutes % 60;
        $totalTime = "{$totalHours} hours {$remainingMinutes} minutes";

        // Update the schedule in the database
        $schedule->update([
            'name' => $request->name,
            'start_time' => $startTime->format('h:i A'),
            'end_time' => $endTime->format('h:i A'),
            'total_minute' => $totalMinutes,
            'total_hourse' => $totalHours,
            'total_time' =>  $totalTime,
        ]);

        return response()->json(['success' => 'Schedule updated successfully.']);
    }

    
    public function destroy ($id){
        $delete = Schedule::find($id)->delete();
    }
    
    
}
