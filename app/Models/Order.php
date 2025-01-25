<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'customer_id', 'price', 'commission_price',
        'title', 'description', 'count_days', 'status'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
