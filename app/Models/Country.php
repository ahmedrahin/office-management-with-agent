<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function jobTypes(){
        return $this->hasMany(JobType::class);
    }

    public function touristPlaces(){
        return $this->hasMany(TouristPlace::class);
    }

    public function university(){
        return $this->hasMany(University::class);
    }

    public function student(){
        return $this->hasMany(Registation::class);
    }

    public function person(){
        return $this->hasMany(JobInquiry::class);
    }

    public function tourist(){
        return $this->hasMany(Tourist::class);
    }
}
