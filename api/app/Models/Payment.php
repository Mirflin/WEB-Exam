<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'policy_id',
        'amount',
        'payment_date',
        'status',
    ];

    public function policy()
    {
        return $this->belongsTo(Policies::class);
    }

    public function status()
    {
        return $this->belongsTo(PaymentStatus::class, 'status');
    }
}
