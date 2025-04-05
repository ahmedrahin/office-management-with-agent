<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignCourse;
use App\Models\Course;
use App\Models\Registation;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
    
        $courses = Course::orderBy('name', 'asc')->where('status', 1)->get();
        $students = Registation::orderBy('name', 'asc')->get();
    
        // Base query
        $assignsQuery = AssignCourse::query();
    
        // Apply filters only if year or month is provided
        if ($year) {
            $assignsQuery->whereRaw('YEAR(STR_TO_DATE(start_date, "%d %b, %Y")) = ?', [$year]);
        }
    
        if ($month) {
            $assignsQuery->whereRaw('MONTH(STR_TO_DATE(start_date, "%d %b, %Y")) = ?', [date('m', strtotime($month))]);
        }
    
        // Fetch results
        $assigns = $assignsQuery->latest()->get();
    
        $allYear = DB::table('assign_courses')
                    ->selectRaw('YEAR(STR_TO_DATE(start_date, "%d %b, %Y")) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');
    
        return view('backend.pages.course.assign', compact('courses', 'students', 'assigns', 'allYear', 'year', 'month'));
    }
    

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'student_id' => 'required',
            'course_id' => 'required',
            'start_date' => 'nullable',
        ]);

        // Check if the course is already assigned to the student
        $existingAssignment = AssignCourse::where('registation_id', $request->student_id) ->where('course_id', $request->course_id)->first();

        if ($existingAssignment) {
            return response()->json(['error' => 'This course is already assigned to the student.'], 400);
        }

        try {
            $assignment = new AssignCourse();
            $assignment->registation_id = $request->student_id;
            $assignment->course_id = $request->course_id;
            $assignment->start_date = $request->start_date ?? Carbon::now()->format('d M, Y');
            $assignment->user_id = Auth::id();
            $assignment->save();

            // payment add
            $assignment->payment()->create([
                'assign_course_id' => $assignment->id,
                'registation_id' => $request->student_id,
                'course_id' => $request->course_id,
                'payment' => $request->payment ?? 0,
                'due_payment' => $assignment->course->fees ?? 0,
                'user_id' => Auth::id(),
            ]);
            

            return response()->json(['success' => 'Course successfully assigned to the student.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while assigning the course. Please try again.', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $delete = AssignCourse::find($id);
        if ($delete) {
            $delete->delete();
            return response()->json([
                'message' => 'Student deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'Student not found.'], 404);
        }
    }


    public function payment(int $id){
        $data = AssignCourse::with('payment')->where('id', $id)->first();
        return view('backend.pages.course.payment', compact('data'));
    }

    public function paymentUpdate(Request $request)
    {
        $lastPayment = Payment::where('assign_course_id', $request->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Calculate new due amount
        $previousDue = $lastPayment ? $lastPayment->due_payment : 0; // Get due_payment value, not the object
        $newDue = ($previousDue - $request->payment);

        // Store new payment
        Payment::create([
            'assign_course_id' => $request->id,
            'registation_id' => $request->registation_id,
            'course_id' => $request->course_id,
            'payment' => $request->payment ?? 0,
            'due_payment' => $newDue, 
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Payment added successfully.');
    }

    public function delete(int $id)
    {   
        // Find the payment to delete
        $payment = Payment::find($id);

        if (!$payment) {
            return redirect()->back()->with('delete', 'Payment not found.');
        }

        // Get assign_course_id before deleting
        $assignCourseId = $payment->assign_course_id;

        // Delete the payment
        $payment->delete();

        // Fetch all remaining payments for this course, sorted by date
        $payments = Payment::where('assign_course_id', $assignCourseId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Get total course fees
        $courseFees = Course::find($payment->course_id)->fees;

        // Recalculate due payments sequentially
        $totalPaid = 0;
        foreach ($payments as $p) {
            $totalPaid += $p->payment;  // Accumulate total paid
            $p->due_payment = $courseFees - $totalPaid; // Update due amount
            $p->save();
        }

        return redirect()->back()->with('delete', 'Payment has been deleted');
    }


    public function invoice(int $id){
        $data = AssignCourse::with('payment')->where('id', $id)->first();
        return view('backend.pages.course.invoice', compact('data'));
    }

}
