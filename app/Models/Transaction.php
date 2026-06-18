<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'package_id', 'coupon_id', 'username', 'password', 'first_name', 'last_name', 'email',
        'students_data', 'student_count',
        'invoice_number', 'amount', 'discount_amount', 'total_amount', 'status',
        'payment_code', 'payment_url', 'moodle_user_id', 'paid_at'
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'password' => 'encrypted',
            'students_data' => 'json',
            'student_count' => 'integer',
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
