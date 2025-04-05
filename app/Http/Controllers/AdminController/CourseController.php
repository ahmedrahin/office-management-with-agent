<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\AssignCourse;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(){
        $courses = Course::latest()->get();

        return view('backend.pages.course.manage', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
        ]);

        // Create and save the new course
        $course = new Course();
        $course->name = $request->course_name;
        $course->fees = $request->course_fees;
        $course->start_time = $request->start_time;
        $course->user_id = Auth::id();
        $course->save();

        // Return a JSON response for AJAX handling
        return response()->json(['message' => 'Course added successfully']);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'course_name' => 'required|string|max:255',
        ]);

        $course = Course::findOrFail($id);
        $course->name = $request->course_name;
        $course->fees = $request->course_fees;
        $course->start_time = $request->start_time;
        $course->save();

        return response()->json(['message' => 'Course updated successfully']);
    }


    public function activeStatus(Request $request, string $id)
    {   
        // update id
        $update = Course::find($id);
        $update->status = $request->status;
        // save
        $update->save();

        $message = $request->status == 0 ? 'Course status is off' : 'Course status is on';
        $type    = $request->status == 0 ? 'info' : 'success';
        return response()->json([
            'msg' => $message,
            'type' => $type,
        ], 200);
    }


    public function show($id)
    {
        $course = Course::with(['assign.registation', 'assign.payment'])->findOrFail($id);

        // Calculate total students
        $totalStudents = $course->assign->count();

        // Calculate total earnings and due
        $totalEarnings = $course->assign->flatMap->payment->sum('payment');
        $totalDue = $course->assign->reduce(function ($carry, $assignment) {
            $lastPayment = $assignment->payment->last();
            $duePayment = $lastPayment ? $lastPayment->due_payment : 0;
            return $carry + $duePayment;
        }, 0);
    
        return view('backend.pages.course.details', compact('course', 'totalStudents', 'totalEarnings', 'totalDue'));
    }




}
