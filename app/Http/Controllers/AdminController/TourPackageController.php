<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourPackages;
use App\Models\TouristPlace;

class TourPackageController extends Controller
{
     public function index(){
        $data = TourPackages::latest()->get();
        return view('backend.pages.package.manage' , compact('data'));
    }


    public function create(){
        $places = TouristPlace::where('status',1)->latest()->get();
        return view('backend.pages.package.add', compact('places'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'places' => 'required|array',
        ]);

        $data = new TourPackages();
        $data->name = $request->name;
        $data->day_night = $request->day_night;
        $data->price = $request->price;
        $data->user_id = auth()->user()->id;
        $data->save();

        foreach ($request->places as $placeId) {
            $data->places()->create([
                'tourist_place_id' => $placeId
            ]);
        }

        return response()->json(['message' => 'Package saved successfully']);
    }

     public function edit(string $id){
        $data = TourPackages::find($id);
        $places = TouristPlace::where('status',1)->latest()->get();
        return view('backend.pages.package.edit', compact('data', 'places'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'places' => 'required|array',
            'places.*' => 'exists:tourist_places,id',
        ]);

        $data = TourPackages::findOrFail($id);
        $data->name = $request->name;
        $data->day_night = $request->day_night;
        $data->price = $request->price;
        $data->user_id = auth()->user()->id;
        $data->save();

        $data->places()->delete();
        foreach ($request->places as $placeId) {
            $data->places()->create([
                'tourist_place_id' => $placeId
            ]);
        }

        return response()->json(['message' => 'Package updated successfully']);
    }

    public function activeStatus(Request $request, string $id)
    {   
        // update id
        $update = TourPackages::find($id);
        $update->status = $request->status;
        // save
        $update->save();

        $message = $request->status == 0 ? 'Package status is off' : 'Package status is on';
        $type    = $request->status == 0 ? 'info' : 'success';
        return response()->json([
            'msg' => $message,
            'type' => $type,
        ], 200);
    }

}
