<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackages extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function places(){
        return $this->hasMany(TourPackagePlaces::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
