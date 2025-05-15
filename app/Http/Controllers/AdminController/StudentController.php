<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Registation;
use App\Models\Country;
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
        $query = Registation::latest();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::createFromFormat('d M, Y', $request->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d M, Y', $request->end_date)->format('Y-m-d');

            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        }

        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        $students = $query->get();

        return view('backend.pages.student.manage', compact('students'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::where('status',1)->latest()->get();
        return view('backend.pages.student.add', compact('countries'));
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
            'country_id'  => 'nullable',
            'university_id'  => 'nullable',
            'total_cost'  => 'nullable',
            'image' => 'nullable|image',
            'front_image' => 'nullable|image',
            'passport_image' => 'nullable|image',
        ]);

        $data = new Registation();

        // image
        $fields = [
            'image' => 'image',
            'front_image' => 'front_image',
            'back_image' => 'back_image',
            'passport_image' => 'passport_image',
        ];

        foreach ($fields as $field => $column) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = time() . '_' . $field . $file->getClientOriginalName();
                $file->move(public_path('/backend/images/student'), $fileName);
                $data->$column = '/backend/images/student/' . $fileName;
            }
        }

        $data->country_id = $request->country_id;
        $data->university_id = $request->university_id;
        $data->subject_id = $request->subject_id;
        $data->total_cost = $request->total_cost ?? 0;
        $data->processing_fees = $request->processing_fees
        ? (float) str_replace(',', '', $request->processing_fees)
        : 0;


        $data->name = $request->name;
        $data->email = $request->email;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->gender = $request->gender;
        $data->date_of_birth = $request->birth;
        $data->mobile = $request->mobile;

        $data->permanent_division = $request->pdivision;
        $data->permanent_district = $request->pdistrict;
        $data->permanent_address = $request->paddress;

        $data->temporary_division = $request->tdivision;
        $data->temporary_district = $request->tdistrict;
        $data->temporary_address = $request->taddress;
        $data->user_id = auth()->user()->id;

        $data->save();

         if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('/backend/images/student'), $fileName);

                // Assuming you have a relation defined in the `Registation` model
                $data->images()->create([
                    'image' => '/backend/images/student/' . $fileName,
                ]);
            }
        }

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
        $student = Registation::with('images')->find($id);
        $countries = Country::where('status',1)->latest()->get();
        return view('backend.pages.student.edit', compact('student', 'countries'));
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
            'country_id'  => 'nullable',
            'university_id'  => 'nullable',
            'total_cost'  => 'nullable',

        ]);


        $data = Registation::findOrFail($id);

        $fields = [
            'image' => 'image',
            'front_image' => 'front_image',
            'back_image' => 'back_image',
            'passport_image' => 'passport_image',
        ];

        foreach ($fields as $field => $column) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = time() . '_' . $field . $file->getClientOriginalName();
                $file->move(public_path('/backend/images/student'), $fileName);
                $data->$column = '/backend/images/student/' . $fileName;
            }
        }

        $data->country_id = $request->country_id;
        $data->university_id = $request->university_id;
        $data->subject_id = $request->subject_id;
        $data->total_cost = $request->total_cost ?? 0;
        $data->processing_fees = $request->processing_fees
                                ? (float) str_replace(',', '', $request->processing_fees)
                                : 0;


        // Update Student Data
        $data->name = $request->name;
        $data->email = $request->email;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->gender = $request->gender;
        $data->date_of_birth = $request->birth;
        $data->courses = $request->course;
        $data->mobile = $request->mobile;

        $data->permanent_division = $request->pdivision;
        $data->permanent_district = $request->pdistrict;
        $data->permanent_address = $request->paddress;

        $data->temporary_division = $request->tdivision;
        $data->temporary_district = $request->tdistrict;
        $data->temporary_address = $request->taddress;

        $data->save();


        if ($request->has('removed_image_ids')) {
            $ids = explode(',', $request->removed_image_ids);
            foreach ($ids as $imageId) {
                $galleryImage = $data->images()->find($imageId);
                if ($galleryImage) {
                    $imagePath = public_path($galleryImage->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $galleryImage->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('/backend/images/student'), $fileName);

                // Save new images in the database
                $data->images()->create([
                    'image' => '/backend/images/student/' . $fileName,
                ]);
            }
        }

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
