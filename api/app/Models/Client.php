<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'personal_code',
        'address',
        'date_of_birth',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function policies()
    {
        return $this->hasMany(Policies::class);
    }
}
