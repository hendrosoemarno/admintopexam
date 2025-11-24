<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodleRoleAssignment extends Model
{
    protected $connection = 'moodle';
    protected $table = 'role_assignments';
    public $timestamps = false;

    public function context()
    {
        return $this->belongsTo(MoodleContext::class, 'contextid');
    }

    public function user()
    {
        return $this->belongsTo(MoodleUser::class, 'userid');
    }
}
