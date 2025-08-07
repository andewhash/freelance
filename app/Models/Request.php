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
        'status',
        'category',
        'country',
        'description',
        'count_days'
    ];

    public function categoryLink()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}
