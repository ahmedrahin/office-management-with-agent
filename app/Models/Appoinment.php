<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    use HasFactory;

    protected $guarded = [];

     public function employees(){
        return $this->belongsTo(Employees::class ,'employees_id');
    }
     public function user(){
        return $this->belongsTo(User::class);
    }
}
