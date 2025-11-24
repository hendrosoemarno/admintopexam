<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodleUser extends Model
{
    protected $connection = 'moodle';
    protected $table = 'user'; // Laravel akan otomatis tambahkan prefix mdl_
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'username', 'password', 'firstname', 'lastname', 'email'
    ];

    public function roles()
    {
        return $this->hasMany(MoodleRoleAssignment::class, 'userid');
    }

}
