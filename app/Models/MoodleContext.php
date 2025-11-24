<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodleContext extends Model
{
    protected $connection = 'moodle';
    protected $table = 'context';
    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo(MoodleCourse::class, 'instanceid');
    }
}
