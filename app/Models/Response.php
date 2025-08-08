<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'text',
        'title',
        'count',
        'category',
        'is_exists',
        'image_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'response_countries');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'response_categories');
    }

    public function images()
    {
        return $this->belongsToMany(File::class, 'response_images');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
