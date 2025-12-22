<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStatus extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_attempt_id', 'is_report_created'];

    protected $casts = [
        'is_report_created' => 'boolean',
    ];
}
