<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Показать модальное окно с формой
    public function create(User $user)
    {
        // Проверяем, может ли пользователь оставить отзыв
        $canReview = Review::canUserReview(Auth::id(), $user->id);
        
        return view('reviews.modal', compact('user', 'canReview'));
    }

    // Сохранить отзыв
    public function store(Request $request, User $user)
    {
        // Проверяем, может ли пользователь оставить отзыв
        if (!Review::canUserReview(Auth::id(), $user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Вы уже оставляли отзыв этому пользователю'
            ], 422);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        try {
            Review::create([
                'author_id' => Auth::id(),
                'recipient_id' => $user->id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Отзыв успешно добавлен!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при сохранении отзыва'
            ], 500);
        }
    }

    // Получить отзывы пользователя
    public function getUserReviews(User $user)
    {
        $reviews = $user->reviewsReceived()
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.list', compact('user', 'reviews'));
    }
}