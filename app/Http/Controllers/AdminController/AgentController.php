<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use Intervention\Image\Colors\Rgb\Channels\Red;

class AgentController extends Controller
{
    public function index(){
        $employees = Agent::orderBy('name', 'asc')->get();
        return view('backend.pages.agent.manage', compact('employees'));
    }

    public function create()
    {   
        return view('backend.pages.agent.add');
    }

    public function store(Request $request)
    {   
        // validation
        $request->validate([
            "name" => "required",
            'email' => 'required|email|unique:agents,email|unique:users,email',
            'phone' => 'nullable|numeric|digits:11',
            'password' => 'required|min:6'
        ],);

        $data = new Agent();

         // image 
         if ($request->hasFile('image')) {
            $thumbImage = $request->file('image');
            $thumbImageName = time() . '_' . $thumbImage->getClientOriginalName();
            $thumbImage->move(public_path('/backend/images/agent'), $thumbImageName);
            $image = '/backend/images/agent/' . $thumbImageName;

            $data->image = $image;
        }

        $data->name        = $request->name;
        $data->email       = $request->email;
        $data->phone       = $request->phone;
        $data->address     = $request->address;
        $data->password    = bcrypt($request->password);
    
        // save
        $data->save();

        return response()->json([
            'success' => true
        ]);
        
    }

    public function show(string $id){
        $student = Agent::find($id);
        return view('backend.pages.agent.show', compact('student'));
    }

    public function edit(string $id){
        $editData = Agent::find($id);
        return view('backend.pages.agent.edit', compact('editData'));
    }

    public function update(Request $request, string $id){
        $request->validate([
            'email' => 'required|email|unique:agents,email,' .$id . '|unique:users,email,'.$id,
            'password' => 'required|min:6'
        ],);

        $data = Agent::find($id);
        $data->email       = $request->email;
        $data->password    = bcrypt($request->password);
        // save
        $data->save();

        return response()->json([
            'success' => true
        ]);

    }

    public function activeStatus(Request $request, string $id)
    {   
        // update id
        $update = Agent::find($id);
        $update->status = $request->status;
        // save
        $update->save();

        $message = $request->status == 0 ? 'Agent status is off' : 'Agent status is on';
        $type    = $request->status == 0 ? 'info' : 'success';
        return response()->json([
            'msg' => $message,
            'type' => $type,
        ], 200);
    }
}
