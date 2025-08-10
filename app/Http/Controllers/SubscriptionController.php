<?php

namespace App\Http\Controllers;

use App\Models\ServiceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function activatePremium(Request $request)
    {
        $user = Auth::user();
        $cost = 100; // $100
        
        if ($user->balance < $cost) {
            return back()->with('error', 'Недостаточно средств на балансе');
        }
        
        if ($user->has_premium_subscription) {
            return back()->with('error', 'Подписка уже активна');
        }

        // Активируем подписку
        $user->has_premium_subscription = true;
        $user->premium_subscription_until = now()->addMonth();
        $user->save();

        // Создаем транзакцию
        ServiceTransaction::create([
            'user_id' => $user->id,
            'service_type' => 'premium_subscription',
            'amount' => $cost,
            'status' => 'completed',
            'details' => 'Подписка "Я первый" на 1 месяц'
        ]);

        // Списание средств
        $user->balance -= $cost;
        $user->save();

        return back()->with('success', 'Подписка "Я первый" успешно активирована');
    }
}