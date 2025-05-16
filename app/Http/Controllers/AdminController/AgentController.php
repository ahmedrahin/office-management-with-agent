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
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $data = new Agent();

        // image
        if ($request->hasFile('image')) {
            $thumbImage = $request->file('image');
            $thumbImageName = time() . '_' . $thumbImage->getClientOriginalName();
            $thumbImage->move(public_path('/backend/images/agent'), $thumbImageName);
            $image = '/backend/images/agent/' . $thumbImageName;

            $data->image = $image;
        }

        $data->name = $request->name;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->wife_name = $request->spouse_name;
        $data->village = $request->village;
        $data->ward_no = $request->ward_no;
        $data->sub_district = $request->sub_district;
        $data->district = $request->district;
        $data->division = $request->division;
        $data->nid_number = $request->nid_number;
        $data->passport_number = $request->passport_number;
        $data->current_address = $request->current_address;
        $data->permanent_address = $request->permanent_address;
        $data->education_qualification = $request->education_qualification;
        $data->study_institute = $request->study_institute;
        $data->previous_experience = $request->previous_experience;
        $data->experience_years = $request->previous_experience ? $request->experience_years : null;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->whatsapp = $request->whatsapp;
        $data->password = bcrypt($request->password);
        $data->institute_name = $request->details;
        // save
        $data->save();

        return response()->json([
            'success' => true
        ]);
    }


    public function show(string $id){
        $agent = Agent::find($id);
        return view('backend.pages.agent.show', compact('agent'));
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
