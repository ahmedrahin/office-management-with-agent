<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Employees;

class TaskController extends Controller
{
    

    public function create(){
        $employees = Employees::orderBy('name', 'asc')->get();
        return view('backend.pages.task.add', compact('employees'));
    }
}
