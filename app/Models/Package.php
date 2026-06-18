<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'price', 'min_students', 'course_id', 'course_name', 'description', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'min_students' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
