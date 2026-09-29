<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'mongodb'; 
    protected $table = 'students';     

    protected $fillable = [
       'name', 'class', 'division', 'age', 'aadhar', 'village', 'dob', 'school_id', 'enrollment_number', 'contact_no', 'emergency_no', 'batch', 'image'
    ];
}
