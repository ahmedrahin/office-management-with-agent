<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('backend.pages.customer.manage', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.customer.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // validation
        $request->validate([
            "name" => "required",
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|numeric',
        ],);

        $customer = new Customer();

         // image 
        if ($request->image) {
            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $image = $manager->read($request->file('image'));
            $image->resize(250, 200);
            $image->save(base_path('public/backend/images/customer/' . $name_gan));

            $customer->image = 'backend/images/customer/' . $name_gan;
        }

        $customer->name         = $request->name;
        $customer->email        = $request->email;
        $customer->phone        = $request->phone;
        $customer->address      = $request->address;
        $customer->shop_name    = $request->shop_name;
        $customer->city         = $request->city;
        $customer->bank_account = $request->bank_account;
        $customer->bank_name    = $request->bank_name;
        $customer->vacation     = $request->vacation;
        // save
        $customer->save();
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Customer::find($id);
        $showData = Customer::where('id', $show->id)->first();
        return view('backend.pages.customer.show', compact('showData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Customer::find($id);
        $editData = Customer::where('id', $edit->id)->first();
        return view('backend.pages.customer.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        // update id
        $update = Customer::find($id);

        // validation
        $request->validate([
            "name" => "required",
            'email'  =>  ['required', Rule::unique('customers')->ignore($update->id)],
            'phone' => 'required|numeric',
        ],);

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
            $image->save(base_path('public/backend/images/customer/' . $name_gan));

            $update->image = 'backend/images/customer/' . $name_gan;
        }

        $update->name         = $request->name;
        $update->email        = $request->email;
        $update->phone        = $request->phone;
        $update->address      = $request->address;
        $update->shop_name    = $request->shop_name;
        $update->city         = $request->city;
        $update->bank_account = $request->bank_account;
        $update->bank_name    = $request->bank_name;
        $update->vacation     = $request->vacation;

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
        $delete = Customer::find($id);
        if ($delete) {
            $delete->delete();
            // delete employee image
            if (File::exists($delete->image)) {
                File::delete($delete->image);
            }
            return response()->json([
                'message' => 'Customer deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'Customer not found.'], 404);
        }
    }
}
