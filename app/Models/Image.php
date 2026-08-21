<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Image extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'images';

    protected $fillable = [
        'student_id',
        'filename',
        'mime_type',
        'data',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
