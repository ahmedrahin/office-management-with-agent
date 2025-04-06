<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;

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
            'email' => 'required|email|unique:agents,email',
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
}
