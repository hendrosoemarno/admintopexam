<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodleCourse extends Model
{
    protected $connection = 'moodle';
    protected $table = 'course';
    public $timestamps = false;
}
