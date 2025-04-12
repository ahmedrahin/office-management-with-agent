<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Tourist;
use App\Models\TouristPlace;

class TourTravelController extends Controller
{
    public function index(Request $request)
    {
        $query = Tourist::latest();

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

        return view('backend.pages.travel.manage', compact('students'));
    }

    public function create()
    {   
        $countries = Country::where('status',1)->latest()->get();
        return view('backend.pages.travel.add', compact('countries'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name"  => "required",
            'email' => 'nullable|email',
            'mobile' => 'required|numeric|digits:11',
            'birth'  => 'nullable',
            'gender'  => 'required',
            'country_id'  => 'required',
            'tourist_place_id'  => 'required',
            'total_cost'  => 'required',
            'image' => 'required|image',
            'front_image' => 'required|image',
            'passport_image' => 'required|image',
        ]);

        $data = new Tourist();

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
                $file->move(public_path('/backend/images/travel'), $fileName);
                $data->$column = '/backend/images/travel/' . $fileName;
            }
        }

        $data->country_id = $request->country_id;
        $data->tourist_place_id = $request->tourist_place_id;
        $data->total_cost = $request->total_cost;

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

    }


    public function show(string $id)
    {
        $student = Tourist::find($id);
        return view('backend.pages.travel.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Tourist::find($id);
        $countries = Country::where('status',1)->latest()->get();
        return view('backend.pages.travel.edit', compact('student', 'countries'));
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
            'country_id'  => 'required',
            'tourist_place_id'  => 'required',
            'total_cost'  => 'required',
        ]);


        $data = Tourist::findOrFail($id);

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
                $file->move(public_path('/backend/images/travel'), $fileName);
                $data->$column = '/backend/images/travel/' . $fileName;
            }
        }

        $data->country_id = $request->country_id;
        $data->tourist_place_id = $request->tourist_place_id;
        $data->total_cost = $request->total_cost;

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

    }

    public function destroy(string $id)
    {
        $delete = Tourist::find($id);
        if ($delete) {
            $delete->delete();
            // delete employee image
            if (File::exists($delete->image)) {
                File::delete($delete->image);
            }
            return response()->json([
                'message' => 'Tourist deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'data not found.'], 404);
        }
    }
}
