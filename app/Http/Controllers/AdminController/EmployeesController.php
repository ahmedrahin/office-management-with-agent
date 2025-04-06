<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Schedule;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rule;
use App\Models\User;
use Carbon\Carbon;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function manage()
    {
        $employees = Employees::orderBy('name', 'asc')->get();
        return view('backend.pages.employees.manage', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $shedules = Schedule::latest()->get();
        return view('backend.pages.employees.add', compact('shedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // validation
        $request->validate([
            "name" => "required",
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|numeric|digits:11',
            'salary' => 'required|numeric',
            'id'  => 'required|string'
        ],);

        $employees = new Employees();

         // image 
        if ($request->employeeImage) {
            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('employeeImage')->getClientOriginalExtension();
            $image = $manager->read($request->file('employeeImage'));
            $image->resize(450, 300);
            $image->save(base_path('public/backend/images/employee/' . $name_gan));

            $employees->image = 'backend/images/employee/' . $name_gan;
        }

        if ($request->signImage) {
            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('signImage')->getClientOriginalExtension();
            $image = $manager->read($request->file('signImage'));
            $image->resize(250, 200);
            $image->save(base_path('public/backend/images/employee/' . $name_gan));

            $employees->sign = 'backend/images/employee/' . $name_gan;
        }

        $employees->name        = $request->name;
        $employees->email       = $request->email;
        $employees->phone       = $request->phone;
        $employees->address     = $request->address;
        $employees->salary      = $request->salary;
        $employees->employee_office_id = $request->id;
        $employees->schedule_id  = $request->schedule_id;
        $employees->position    = $request->position;
        $employees->join_date    = $request->join_date ?? Carbon::now()->format('d M, Y');

        // save
        $employees->save();
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Employees::find($id);
        $editData = Employees::where('id', $edit->id)->first();
        $shedules = Schedule::latest()->get();
        return view('backend.pages.employees.edit', compact('editData', 'shedules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        // update id
        $update = Employees::find($id);

        // validation
        $request->validate([
            "name" => "required",
            'email'  =>  ['required', Rule::unique('employees')->ignore($update->id)],
            'phone' => 'required|numeric',
            'salary' => 'required|numeric',
            'id'  => 'required|string'
        ],);


         // image 
        if($request->employeeHasRemove){
            // delete employee image
            if (File::exists($update->image)) {
                File::delete($update->image);
            }
            $update->image = null;
        }
        elseif ($request->employeeImage) {
            // delete employee image
            if (File::exists($update->image)) {
                File::delete($update->image);
            }

            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('employeeImage')->getClientOriginalExtension();
            $image = $manager->read($request->file('employeeImage'));
            $image->resize(450, 300);
            $image->save(base_path('public/backend/images/employee/' . $name_gan));

            $update->image = 'backend/images/employee/' . $name_gan;
        }

        if($request->signHasRemove){
            // delete employee image
            if (File::exists($update->sign)) {
                File::delete($update->sign);
            }
            $update->sign = null;
        }
        elseif ($request->signImage) {
            // delete employee image
            if (File::exists($update->sign)) {
                File::delete($update->sign);
            }

            $manager = new ImageManager(new Driver());
            $name_gan = hexdec(uniqid()) . '.' . $request->file('signImage')->getClientOriginalExtension();
            $image = $manager->read($request->file('signImage'));
            $image->resize(250, 200);
            $image->save(base_path('public/backend/images/employee/' . $name_gan));

            $update->sign = 'backend/images/employee/' . $name_gan;
        }

        $update->name        = $request->name;
        $update->email       = $request->email;
        $update->phone       = $request->phone;
        $update->address     = $request->address;
        $update->salary      = $request->salary;
        $update->employee_office_id  = $request->id;
        $update->office_hours  = $request->hours;
        $update->schedule_id  = $request->schedule_id;
        $update->position    = $request->position;
        $update->join_date    = $request->join_date ?? Carbon::now()->format('d M, Y');
        // save
        $update->save();
        
        $user = User::where('employees_id', $update->id)->first();
        if ($user) {
            $user->update([
                'name' => $update->name,
                'email' => $update->email,
            ]);
        } 

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
        $delete = Employees::find($id);
        if ($delete) {
            $delete->delete();
            // delete employee image
            if (File::exists($delete->image)) {
                File::delete($delete->image);
            }
            if (File::exists($delete->sign)) {
                File::delete($delete->sign);
            }
            return response()->json([
                'message' => 'Employee deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'Employee not found.'], 404);
        }
    }
}
