<?php

namespace App\Http\Controllers;

use App\Models\AdPosition;
use App\Models\ServiceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AdPositionController extends Controller
{
    public function bidSearch(Request $request)
{
    $request->validate([
        'bid' => 'required|numeric|min:1'
    ]);

    $user = Auth::user();
    $bidAmount = $request->bid;
    
    // Получаем минимальную текущую ставку
    $minBid = User::where('order_search', '>', 0)
        ->orderBy('order_search', 'ASC')
        ->value('order_search') ?? 0;
    
    // Проверяем, что ставка выше минимальной
    if ($bidAmount <= $minBid) {
        return back()->with('error', 'Ваша ставка должна быть выше ' . $minBid . ' ₽');
    }

    if ($user->balance < $bidAmount) {
        return back()->with('error', 'Недостаточно средств на балансе');
    }

    // Обновляем ставку пользователя
    $user->order_search = $bidAmount;
    $user->save();

    // Создаем транзакцию
    ServiceTransaction::create([
        'user_id' => $user->id,
        'service_type' => 'search_ad',
        'amount' => $bidAmount,
        'status' => 'confirmed',
        'details' => 'Реклама в поиске с ставкой ' . $bidAmount . ' ₽'
    ]);

    // Списание средств
    $user->balance -= $bidAmount;
    $user->save();

    return back()->with('success', 'Ваша ставка успешно принята. Ваша позиция будет обновлена.');
}

public function bidCatalog(Request $request)
{
    $request->validate([
        'bid' => 'required|numeric|min:1'
    ]);

    $user = Auth::user();
    $bidAmount = $request->bid;
    
    // Получаем минимальную текущую ставку
    $minBid = User::where('order_catalog', '>', 0)
        ->orderBy('order_catalog', 'ASC')
        ->value('order_catalog') ?? 0;
    
    // Проверяем, что ставка выше минимальной
    if ($bidAmount <= $minBid) {
        return back()->with('error', 'Ваша ставка должна быть выше ' . $minBid . ' ₽');
    }

    if ($user->balance < $bidAmount) {
        return back()->with('error', 'Недостаточно средств на балансе');
    }

    // Обновляем ставку пользователя
    $user->order_catalog = $bidAmount;
    $user->save();

    // Создаем транзакцию
    ServiceTransaction::create([
        'user_id' => $user->id,
        'service_type' => 'catalog_ad',
        'amount' => $bidAmount,
        'status' => 'confirmed',
        'details' => 'Реклама в каталоге с ставкой ' . $bidAmount . ' ₽'
    ]);

    // Списание средств
    $user->balance -= $bidAmount;
    $user->save();

    return back()->with('success', 'Ваша ставка успешно принята. Ваша позиция будет обновлена.');
}
}