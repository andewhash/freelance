<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'seller_id',
        'price',
        'commission_price',
        'title',
        'description',
        'count_days'
    ];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

}
