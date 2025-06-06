<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function university(){
        return $this->belongsTo(University::class);
    }

    public function student(){
        return $this->hasMany(Registation::class);
    }
}
