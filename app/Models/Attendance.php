<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Attendance extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'attendances';

    protected $fillable = [
        'date',
        'class',
        'division',
        'topic',
        'school_id',
        'students',
        'message',
        'subject',
        'lecture_type',
        'period'
    ];

    protected $casts = [
        'date' => 'date',
        'students' => 'array'
    ];
}
