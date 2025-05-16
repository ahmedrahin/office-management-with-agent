<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AgentProfile extends Controller
{
    public function index(){
        return view('agent.pages.profile');
    }

   public function updateInfo(Request $request, $id){
        $user = Agent::find($id);

        $request->validate([
            "name" => "required",
            'email' => 'required|email|unique:agents,email,'.$user->id,
        ]);

        // Image handling
        if($request->hasRemove){
            // delete old image if exists
            if (File::exists($user->image)) {
                File::delete($user->image);
            }
            $user->image = null;
        } elseif ($request->image) {
            // delete old image if exists
            if (File::exists($user->image)) {
                File::delete($user->image);
            }

            $thumbImage = $request->file('image');
            $thumbImageName = time() . '_' . $thumbImage->getClientOriginalName();
            $thumbImage->move(public_path('/backend/images/agent'), $thumbImageName);
            $image = '/backend/images/agent/' . $thumbImageName;

            $user->image = $image;
        }

        // Updating the fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->whatsapp = $request->whatsapp;
        $user->current_address = $request->current_address;
        $user->permanent_address = $request->permanent_address;
        $user->division = $request->division;
        $user->district = $request->district;
        $user->sub_district = $request->sub_district;
        $user->ward_no = $request->ward_no;
        $user->village = $request->village;
        $user->nid_number = $request->nid_number;
        $user->passport_number = $request->passport_number;
        $user->education_qualification = $request->education_qualification;
        $user->study_institute = $request->study_institute;
        $user->previous_experience = $request->previous_experience;
        $user->experience_years = $request->experience_years;
        $user->institute_name = $request->institute_name;

        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->wife_name = $request->wife_name;

        // Save the updated information
        $user->save();
    }


    public function updatePassoword(Request $request, $id){
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = Agent::findOrFail($id);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Current password does not match our records.',
            ]);
        }

        // Update password
        $user->password = bcrypt($request->password);
        $user->save();
    }
}
