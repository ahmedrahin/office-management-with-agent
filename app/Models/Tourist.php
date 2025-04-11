<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tourist extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function TouristPlace(){
        return $this->belongsTo(TouristPlace::class, 'tourist_place_id');
    }
}
