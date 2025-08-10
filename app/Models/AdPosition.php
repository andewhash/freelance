<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'position',
        'current_bid',
        'current_user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'current_user_id');
    }
}