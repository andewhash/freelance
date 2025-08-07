<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
