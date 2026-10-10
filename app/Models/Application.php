<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Job;
use App\Models\Student;

class Application extends Model
{
    protected $fillable = [
        'student_id',
        'job_id',
        'resume',
        'status',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}