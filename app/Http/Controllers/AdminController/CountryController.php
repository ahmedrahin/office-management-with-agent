<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(){
        $data = Country::latest()->get();
        return view('backend.pages.country.manage' , compact('data'));
    }


    public function create(){
        return view('backend.pages.country.add');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:countries,name',
        ]);

        $data = new Country();
        $data->name = $request->name;
        $data->user_id = auth()->user()->id;
        $data->save();

        return response()->json(['message' => 'Country saved successfully']);
    }

    public function edit(string $id){
        $data = Country::find($id);
        return view('backend.pages.country.edit', compact('data'));
    }

    public function update(Request $request, string $id){
        $data = Country::find($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,' . $data->id,
        ]);

        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Country has been updated successfully']);
    }

    public function activeStatus(Request $request, string $id)
    {   
        // update id
        $update = Country::find($id);
        $update->status = $request->status;
        // save
        $update->save();

        $message = $request->status == 0 ? 'Country status is off' : 'Country status is on';
        $type    = $request->status == 0 ? 'info' : 'success';
        return response()->json([
            'msg' => $message,
            'type' => $type,
        ], 200);
    }
}
