<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Response;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        $user->update($request->only('name', 'mobile', 'email', 'location'));
        return back();
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('avatars', 'public');
            $user->update(['image_url' => $imagePath]);
        }

        return back();
    }

    public function orders(Request $request)
    {
        $query = Order::query();

        // Фильтр по названию
        if ($request->has('name') && $request->get('name') !== '') {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }

        // Фильтры по сумме от и до
        if ($request->has('amount_from') && $request->get('amount_from') !== '') {
            $query->where('price', '>=', $request->get('amount_from'));
        }

        if ($request->has('amount_to') && $request->get('amount_to') !== '') {
            $query->where('price', '<=', $request->get('amount_to'));
        }

        // Сортировка
        if ($request->has('sort_by') && $request->get('sort_by') === 'price') {
            $query->orderBy('price', 'asc'); // по цене
        } elseif ($request->has('sort_by') && $request->get('sort_by') === 'latest') {
            $query->orderBy('created_at', 'desc'); // по последним
        }

        // Проверяем роль пользователя и загружаем соответствующие заказы
        $orders = $query->paginate(8);

        return view('orders', compact('orders'));
    }


// Метод для отображения конкретного заказа
    public function showOrder(Order $order)
    {
        // Проверка, что заказ принадлежит текущему пользователю
        return view('profile.showOrder', compact('order'));
    }

    // Метод для отображения заказов в профиле
    public function profileOrders()
    {
        $orders = auth()->user()->orders;  // Получаем все заказы пользователя
        return view('profile.profileOrders', compact('orders'));
    }

    public function responses()
    {
        $responses = Response::where('user_id', auth()->id())->with('order')->paginate(25);

        return view('profile.responses', compact('responses'));
    }

    public function orderPropose(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if (!Response::where('order_id', $order->id)->where('user_id', auth()->id())->exists()) {
            Response::create([
                'order_id' => $order->id,
                'text' => $request->get('text') ?? '',
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('orders')->with('success', 'Ваше предложение было отправлено!');
        }

        return redirect()->route('orders')->with('success', 'Ваше предложение было отправлено!');
    }
}
