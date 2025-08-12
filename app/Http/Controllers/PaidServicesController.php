<?php

namespace App\Http\Controllers;

use App\Models\ServiceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaidServicesController extends Controller
{
    public function verifyRequest(Request $request)
    {
        $user = Auth::user();
        $cost = 50; // $50
        
        if ($user->balance < $cost) {
            return back()->with('error', 'Недостаточно средств на балансе');
        }
        
        // Создаем транзакцию
        $transaction = ServiceTransaction::create([
            'user_id' => $user->id,
            'service_type' => 'company_verification',
            'amount' => $cost,
            'status' => 'pending',
            'details' => 'Запрос на проверку компании'
        ]);
        
        // Здесь можно отправить уведомление админу
        $user->balance -= 50;
        $user->save();
        
        return back()->with('success', 'Запрос на проверку компании отправлен. Ожидайте решения администратора.');
    }
}