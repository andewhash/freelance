<?php

namespace App\Http\Controllers;

use App\Models\BannerAd;
use App\Models\ServiceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannerAdController extends Controller
{
    public function create()
    {
        $categories = ['Главная', 'Категория 1', 'Категория 2']; // Здесь нужно получать реальные категории
        return view('paid-services.banner', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'required|array',
            'duration' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cost = 100 * $request->duration; // $100 в месяц
        
        if ($user->balance < $cost) {
            return back()->with('error', 'Недостаточно средств на балансе');
        }

        // Загрузка изображения
        $imagePath = $request->file('image')->store('banners', 'public');

        // Создание баннера
        $banner = BannerAd::create([
            'user_id' => $user->id,
            'image_path' => $imagePath,
            'link' => $request->link,
            'categories' => $request->categories,
            'start_date' => now(),
            'end_date' => now()->addMonths($request->duration)
        ]);

        // Создание транзакции
        ServiceTransaction::create([
            'user_id' => $user->id,
            'service_type' => 'banner_ad',
            'amount' => $cost,
            'status' => 'confirmed',
            'details' => 'Баннерная реклама на ' . $request->duration . ' месяцев'
        ]);

        // Списание средств
        $user->balance -= $cost;
        $user->save();

        return redirect()->route('profile')->with('success', 'Баннер успешно создан и будет активирован после модерации');
    }
}