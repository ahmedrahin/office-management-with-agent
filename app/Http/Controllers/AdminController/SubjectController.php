<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\University;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index(){
        $data = Subject::latest()->get();
        return view('backend.pages.university.manage' , compact('data'));
    }


    public function create(){
        $universitys = University::where('status',1)->latest()->get();
        return view('backend.pages.subject.add', compact('universitys'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'university_id' => 'required',
            'price' => 'required|numeric',
        ],[
            'university_id.required' => 'Please select a university',
            'price.required' => 'Please enter a fees'
        ]);

        $data = new Subject();
        $data->name = $request->name;
        $data->price = number_format($request->price,2);
        $data->university_id = $request->university_id;
        $data->user_id = auth()->user()->id;
        $data->save();

        return response()->json(['message' => 'Subject saved successfully']);
    }

    public function edit(string $id){
        $data = Subject::find($id);
        $universitys = University::where('status',1)->latest()->get();
        return view('backend.pages.subject.edit', compact('data', 'universitys'));
    }

    public function update(Request $request, string $id){
        $data = Subject::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'university_id' => 'required',
            'price' => 'required',
        ],[
            'university_id.required' => 'Please select a university',
            'price.required' => 'Please enter a fees'
        ]);

        $rawPrice = preg_replace('/[^\d.]/', '', $request->price);

        $data->name = $request->name;
        $data->price = number_format((float) $rawPrice, 2, '.', '');
        $data->university_id = $request->university_id;
        $data->save();

        return response()->json(['message' => 'Subject has been updated successfully']);
    }

    public function destroy(string $id)
    {
        $delete = Subject::find($id);
        if ($delete) {
            $delete->delete();
            return response()->json([
                'message' => 'Subject deleted successfully.',
            ]);
        } else {
            return response()->json(['error' => 'data not found.'], 404);
        }
    }

    public function activeStatus(Request $request, string $id)
    {   
        // update id
        $update = Subject::find($id);
        $update->status = $request->status;
        // save
        $update->save();

        $message = $request->status == 0 ? 'Subject status is off' : 'Subject status is on';
        $type    = $request->status == 0 ? 'info' : 'success';
        return response()->json([
            'msg' => $message,
            'type' => $type,
        ], 200);
    }
}
