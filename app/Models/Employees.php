<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function salaries(){
        return $this->hasMany(Salarie::class);
    }

    public function attendance(){
        return $this->hasMany(Attendance::class, 'emp_id');
    }
    
}
