<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'company_id',
        'job_title',
        'job_type',
        'location',
        'salary',
        'experience',
        'vacancy',
        'description',
        'deadline',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
