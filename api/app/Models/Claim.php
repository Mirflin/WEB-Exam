<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [
        'policy_id',
        'claim_number',
        'description',
        'status',
    ];

    public function policy()
    {
        return $this->belongsTo(Policies::class);
    }

    public function status()
    {
        return $this->belongsTo(ClaimStatus::class, 'status');
    }
}
