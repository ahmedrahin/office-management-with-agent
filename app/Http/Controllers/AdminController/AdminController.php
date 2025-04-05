<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('backend.pages.admin.manage', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employees::get();
        return view('backend.pages.admin.add', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'employee_id'  => 'required|int|exists:employees,id|unique:users,employees_id',
            'password'      => 'required|string|min:6',
            'role'     => 'required|in:1,2,3'
        ],[
            'employee_id.required' => 'Please select a employee',
            'employee_id.unique' => 'This employee already enrolled'
        ]);

        $employee = Employees::where('id', $request->input('employee_id'))->first();

        // Example: creating a new user
        $user = User::create([
            'employees_id' => $request->employee_id,
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => bcrypt($validatedData['password']),
            'role_id' => $request->role
        ]);
    
        return response()->json([
            'success' => ' create successfully.',
        ], 200);
    }

    public function activeStatus(Request $request, string $id)
    {   
        // update id
        $update = User::find($id);
        $update->status = $request->status;
        // save
        $update->save();

        $message = $request->status == 0 ? 'Admin status is off' : 'Admin status is on';
        $type    = $request->status == 0 ? 'info' : 'success';
        return response()->json([
            'msg' => $message,
            'type' => $type,
        ], 200);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = User::find($id);
        $editData = User::where('id', $edit->id)->first();
        return view('backend.pages.admin.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming data
        $request->validate([
            'password' => 'nullable|string|confirmed|min:6',
            'role'     => 'required|in:1,2,3'
        ]);
    
        // Find the admin by ID
        $admin = User::findOrFail($id);

        if( $id == 1 ){
            $admin->name = $request->name;
            $admin->email = $request->email;
        }
        else {
            $admin->role_id = $request->role;
        }

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->input('password'));
        }
      
        $admin->save();
        
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = User::find($id);
        if ($delete) {
            $delete->delete();
            return response()->json([
                'message' => 'Admin deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'Admin not found.'], 404);
        }
    }
}
