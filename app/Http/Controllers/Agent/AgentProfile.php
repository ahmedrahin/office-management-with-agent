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
        ],);

         // image 
         if($request->hasRemove){
            // delete employee image
            if (File::exists($user->image)) {
                File::delete($user->image);
            }
            $user->image = null;
        }
        elseif ($request->image) {
            // delete user image
            if (File::exists($user->image)) {
                File::delete($user->image);
            }

            $thumbImage = $request->file('image');
            $thumbImageName = time() . '_' . $thumbImage->getClientOriginalName();
            $thumbImage->move(public_path('/backend/images/agent'), $thumbImageName);
            $image = '/backend/images/agent/' . $thumbImageName;

            $user->image = $image;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        // save
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
