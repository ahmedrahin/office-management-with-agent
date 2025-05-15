<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobInquiry extends Model
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

    public function jobtype(){
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

     public function images(){
        return $this->hasMany(JobInquiryImages::class);
    }

}
