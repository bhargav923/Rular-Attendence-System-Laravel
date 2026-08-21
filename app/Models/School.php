<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class School extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'schools';

    protected $fillable = [
        'school_name',
        'principal_name',
        'email',
        'password',
        'address',
        'phone',
        'status'
    ];

    protected $hidden = ['password'];
}
