<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function assign(){
        return $this->hasMany(AssignCourse::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function university(){
        return $this->belongsTo(University::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
