<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'seller_id',
        'price',
        'commission_price',
        'title',
        'country',
        'category',
        'status',
        'description',
        'count_days'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'request_categories');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'request_countries');
    }

    public function images()
    {
        return $this->belongsToMany(File::class, 'request_images');
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
