<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'recipient_id',
        'rating',
        'comment'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    // Автор отзыва
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Получатель отзыва
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    // Проверка, может ли пользователь оставить отзыв
    public static function canUserReview($authorId, $recipientId)
    {
        return !self::where('author_id', $authorId)
            ->where('recipient_id', $recipientId)
            ->exists();
    }
}
