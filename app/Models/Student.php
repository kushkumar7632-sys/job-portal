<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password'
    ]; 

    protected $hidden = [
        'password',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
