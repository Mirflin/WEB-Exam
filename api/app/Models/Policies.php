<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policies extends Model
{
    protected $fillable = [
        'client_id',
        'policy_number',
        'type',
        'start_date',
        'end_date',
        'premium_amount',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function status()
    {
        return $this->belongsTo(PoliciesStatus::class, 'status');
    }
}
