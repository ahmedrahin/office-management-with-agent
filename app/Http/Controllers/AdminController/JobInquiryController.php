<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobInquiry;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Country;

class JobInquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = JobInquiry::latest();

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

        return view('backend.pages.inquiry.manage', compact('students'));
    }

    public function create()
    {   
        $countries = Country::where('status',1)->latest()->get();
        return view('backend.pages.inquiry.add', compact('countries'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name"  => "required",
            'email' => 'nullable|email',
            'mobile' => 'required|numeric',
            'birth'  => 'nullable',
            'gender'  => 'required',
            'country_id'  => 'nullable',
            'job_type_id'  => 'nullable',
            'total_cost'  => 'nullable',
            'image' => 'nullable|image',
            'front_image' => 'nullable|image',
            'passport_image' => 'nullable|image',
        ]);

        $data = new JobInquiry();

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
                $file->move(public_path('/backend/images/person'), $fileName);
                $data->$column = '/backend/images/person/' . $fileName;
            }
        }

        $data->country_id = $request->country_id;
        $data->job_type_id = $request->job_type_id;
        $data->total_cost = $request->total_cost ?? 0;

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
                $image->move(public_path('/backend/images/person'), $fileName);

                // Assuming you have a relation defined in the `Registation` model
                $data->images()->create([
                    'image' => '/backend/images/person/' . $fileName,
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = JobInquiry::find($id);

        return view('backend.pages.inquiry.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = JobInquiry::find($id);
        $countries = Country::where('status',1)->latest()->get();
        return view('backend.pages.inquiry.edit', compact('student', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"  => "required",
            'email' => 'nullable|email',
            'mobile' => 'required|numeric',
            'birth'  => 'nullable',
            'gender'  => 'required',
            'country_id'  => 'nullable',
            'job_type_id'  => 'nullable',
            'total_cost'  => 'nullable',
        ]);


        $data = JobInquiry::findOrFail($id);

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
                $file->move(public_path('/backend/images/person'), $fileName);
                $data->$column = '/backend/images/person/' . $fileName;
            }
        }

        $data->country_id = $request->country_id;
        $data->job_type_id = $request->job_type_id;
        $data->total_cost = $request->total_cost ?? 0;

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
                $image->move(public_path('/backend/images/person'), $fileName);

                // Save new images in the database
                $data->images()->create([
                    'image' => '/backend/images/person/' . $fileName,
                ]);
            }
        }

    }

    public function destroy(string $id)
    {
        $delete = JobInquiry::find($id);
        if ($delete) {
            $delete->delete();
            // delete employee image
            if (File::exists($delete->image)) {
                File::delete($delete->image);
            }
            return response()->json([
                'message' => 'Person deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'data not found.'], 404);
        }
    }
}
