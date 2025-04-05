<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Registation;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with all students
        $query = Registation::latest();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::createFromFormat('d M, Y', $request->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d M, Y', $request->end_date)->format('Y-m-d');

            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }

        // Get the filtered students
        $students = $query->get();

        // Return the view with filtered students
        return view('backend.pages.student.manage', compact('students'));
    }

    public function filter(Request $request)
    {
        dd(1);
        $query = Registation::latest();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::createFromFormat('d M, Y', $request->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d M, Y', $request->end_date)->format('Y-m-d');

            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }

        $students = $query->get();

        return view('backend.pages.student.manage', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.student.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name"  => "required",
            'email' => 'nullable|email',
            'mobile' => 'required|numeric|digits:11',
            'birth'  => 'nullable',
            'gender'  => 'required',
        ]);

        $student = new Registation();

        // image 
        if ($request->image) {
            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->save(base_path('public/backend/images/student/' . $name_gan));

            $student->image = 'backend/images/student/' . $name_gan;
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->father_name = $request->father_name;
        $student->mother_name = $request->mother_name;
        $student->gender = $request->gender;
        $student->date_of_birth = $request->birth;
        $student->courses = $request->course;
        $student->mobile = $request->mobile;

        $student->permanent_division = $request->pdivision;
        $student->permanent_district = $request->pdistrict;
        $student->permanent_address = $request->paddress;

        $student->temporary_division = $request->tdivision;
        $student->temporary_district = $request->tdistrict;
        $student->temporary_address = $request->taddress;

        $student->user_id = auth()->user()->id;

        $student->save();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Registation::with('assign')->find($id);

        $totalCourse = $student->assign->count();
        $totalPaid   = $student->assign->flatMap->payment->sum('payment');
        $totalDue = $student->assign->reduce(function ($carry, $assignment) {
            $lastPayment = $assignment->payment->last();
            $duePayment = $lastPayment ? $lastPayment->due_payment : 0;
            return $carry + $duePayment;
        }, 0);

        return view('backend.pages.student.show', compact('student', 'totalCourse', 'totalPaid', 'totalDue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Registation::find($id);
        return view('backend.pages.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"  => "required",
            'email' => 'nullable|email',
            'mobile' => 'required|numeric|digits:11',
            'birth'  => 'nullable',
            'gender'  => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $student = Registation::findOrFail($id);

        // Handling Image Upload
        if($request->hasRemove){
            // delete employee image
            if (File::exists($student->image)) {
                File::delete($student->image);
            }
            $student->image = null;
        }
        elseif($request->image) {
            // Delete old image if exists
            if ($student->image && file_exists(public_path($student->image))) {
                File::delete($student->image);
            }

            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->save(base_path('public/backend/images/student/' . $name_gan));

            $student->image = 'backend/images/student/' . $name_gan;
        }

        // Update Student Data
        $student->name = $request->name;
        $student->email = $request->email;
        $student->father_name = $request->father_name;
        $student->mother_name = $request->mother_name;
        $student->gender = $request->gender;
        $student->date_of_birth = $request->birth;
        $student->courses = $request->course;
        $student->mobile = $request->mobile;

        $student->permanent_division = $request->pdivision;
        $student->permanent_district = $request->pdistrict;
        $student->permanent_address = $request->paddress;

        $student->temporary_division = $request->tdivision;
        $student->temporary_district = $request->tdistrict;
        $student->temporary_address = $request->taddress;

        $student->save();

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Registation::find($id);
        if ($delete) {
            $delete->delete();
            // delete employee image
            if (File::exists($delete->image)) {
                File::delete($delete->image);
            }
            return response()->json([
                'message' => 'Student deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'Student not found.'], 404);
        }
    }
}
