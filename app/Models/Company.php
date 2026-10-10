<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'company_name',
        'owner_name',
        'email',
        'phone',
        'website',
        'industry',
        'address',
        'password',
        'is_approved'
    ];
    protected $hidden = [
        'password',
    ];
}
