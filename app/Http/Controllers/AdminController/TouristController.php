<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\TouristPlace;

class TouristController extends Controller
{
    public function index(){
        $data = TouristPlace::latest()->get();
        return view('backend.pages.tourist.manage' , compact('data'));
    }


    public function create(){
        $countries = Country::where('status',1)->latest()->get();
        return view('backend.pages.tourist.add', compact('countries'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required'
        ],[
            'country_id' => 'Please select a country'
        ]);

        $data = new TouristPlace();
        $data->name = $request->name;
        $data->country_id = $request->country_id;
        $data->user_id = auth()->user()->id;
        $data->save();

        return response()->json(['message' => 'Tourist Place saved successfully']);
    }

    public function show(string $id){
        
    }

    public function edit(string $id){
        $data = TouristPlace::find($id);
        $countries = Country::where('status',1)->latest()->get();
        return view('backend.pages.tourist.edit', compact('data', 'countries'));
    }

    public function update(Request $request, string $id){
        $data = TouristPlace::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required'
        ],[
            'country_id' => 'Please select a country'
        ]);

        $data->name = $request->name;
        $data->country_id = $request->country_id;
        $data->save();

        return response()->json(['message' => 'Tourist Place has been updated successfully']);
    }

    public function destroy(string $id)
    {
        $delete = TouristPlace::find($id);
        if ($delete) {
            $delete->delete();
            return response()->json([
                'message' => 'Touris tPlace deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'data not found.'], 404);
        }
    }

    public function activeStatus(Request $request, string $id)
    {   
        // update id
        $update = TouristPlace::find($id);
        $update->status = $request->status;
        // save
        $update->save();

        $message = $request->status == 0 ? 'Tourist Place status is off' : 'Tourist Place status is on';
        $type    = $request->status == 0 ? 'info' : 'success';
        return response()->json([
            'msg' => $message,
            'type' => $type,
        ], 200);
    }
}
