<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Intervention\Image\Colors\Rgb\Channels\Red;

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
        $data->save();

        return response()->json(['message' => 'Country saved successfully']);
    }
}
