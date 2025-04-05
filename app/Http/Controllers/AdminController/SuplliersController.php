<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suplliers;
use File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rule;

class SuplliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $suplliers = Suplliers::orderBy('name', 'asc')->get();
        return view('backend.pages.supplier.manage', compact('suplliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.supplier.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // validation
         $request->validate([
            "name"  => "required",
            'email' => 'required|email|unique:suplliers,email',
            'phone' => 'required|numeric',
            'type'  => 'required',
        ],[
            'type.required' => "Please select supplier type"
        ]);

        $suplliers = new Suplliers();

         // image 
        if ($request->image) {
            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->resize(250, 200);
            $image->save(base_path('public/backend/images/suplliers/' . $name_gan));

            $suplliers->image = 'backend/images/suplliers/' . $name_gan;
        }

        $suplliers->name            = $request->name;
        $suplliers->email           = $request->email;
        $suplliers->phone           = $request->phone;
        $suplliers->address         = $request->address;
        $suplliers->shop_name       = $request->shop_name;
        $suplliers->city            = $request->city;
        $suplliers->bank_account    = $request->bank_account;
        $suplliers->account_holder  = $request->holder;
        $suplliers->bank_name       = $request->bank_name;
        $suplliers->type            = $request->type;
        // save
        $suplliers->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Suplliers::find($id);
        $showData = Suplliers::where('id', $show->id)->first();
        return view('backend.pages.supplier.show', compact('showData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Suplliers::find($id);
        $editData = Suplliers::where('id', $edit->id)->first();
        return view('backend.pages.supplier.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        // update id
        $update = Suplliers::find($id);

        // validation
        $request->validate([
            "name" => "required",
            'email'  =>  ['required', Rule::unique('suplliers')->ignore($update->id)],
            'phone' => 'required|numeric',
            'type'  => 'required',
        ],[
            'type.required' => "Please select supplier type"
        ]);

         // image 
        if($request->hasRemove){
            // delete employee image
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $update->image = null;
        }
        elseif ($request->image) {
            // delete employee image
            if (File::exists($update->image)) {
                File::delete($update->image);
            }

            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->resize(250, 200);
            $image->save(base_path('public/backend/images/suplliers/' . $name_gan));

            $update->image = 'backend/images/suplliers/' . $name_gan;
        }

        $update->name            = $request->name;
        $update->email           = $request->email;
        $update->phone           = $request->phone;
        $update->address         = $request->address;
        $update->shop_name       = $request->shop_name;
        $update->city            = $request->city;
        $update->bank_account    = $request->bank_account;
        $update->account_holder  = $request->holder;
        $update->bank_name       = $request->bank_name;
        $update->type            = $request->type;

        // save
        $update->save();
       // Return success response with the updated employee data
        return response()->json([
            'success' => 'Information updated successfully.',
            'editData' => $update
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Suplliers::find($id);
        if ($delete) {
            $delete->delete();
            // delete employee image
            if (File::exists($delete->image)) {
                File::delete($delete->image);
            }
            return response()->json([
                'message' => 'Suplliers deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'Suplliers not found.'], 404);
        }
    }

}
