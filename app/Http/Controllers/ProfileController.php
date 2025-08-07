<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Response;
use Illuminate\Http\Request;

use App\Models\Request as RequestModel;
class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        $user->update($request->only('name', 'phone', 'email', 'address'));
        return back();
    }

    public function updateStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $customer = $order->customer; // Пользователь, который заказал
        $seller = $order->seller; // Исполнитель

        // Если переводим в работу, проверяем баланс
        if ($request->status === 'IN_WORK' && in_array($order->status, ['NEW', 'WAITING_PAYMENT'])) {
            if ($customer->balance >= $order->price) {
                $customer->balance -= $order->price; // Снимаем деньги
                $customer->save();

                $order->status = 'IN_WORK';
                $order->save();

                return response()->json(['success' => true, 'new_balance' => $customer->balance]);
            } else {
                return response()->json(['success' => false, 'message' => 'Недостаточно средств на балансе'], 400);
            }
        }

        // Если переводим в "Выполнено" - переводим деньги продавцу
        if ($request->status === 'COMPLETED' && $order->status === 'VERIFICATION') {
            $seller->balance += $order->price; // Начисляем деньги продавцу
            $seller->save();

            $order->status = 'COMPLETED';
            $order->save();

            return response()->json(['success' => true, 'seller_balance' => $seller->balance]);
        }

        // Если статус - просто обычное обновление, без доп. проверок
        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true]);
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

    public function requests(Request $request)
    {
        $query = RequestModel::query()->whereDoesntHave('responses', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        });

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
        $requests = $query->paginate(8);

        return view('requests', compact('requests'));
    }

// Метод для отображения конкретного заказа
    public function showRequests(RequestModel $request)
    {
        // Проверка, что заказ принадлежит текущему пользователю
        return view('profile.showRequest', compact('request'));
    }

    // Метод для отображения заказов в профиле
    public function profileOrders()
    {
        $orders = auth()->user()->orders;  // Получаем все заказы пользователя
        return view('profile.profileOrders', compact('orders'));
    }

    public function responses()
    {
        $responses = Response::where('user_id', auth()->id())->with('request')->paginate(25);

        return view('profile.responses', compact('responses'));
    }

    public function orderPropose(Request $request, $id)
    {
        $requestModel = RequestModel::findOrFail($id);
        if (!Response::where('request_id', $requestModel->id)->where('user_id', auth()->id())->exists()) {
            Response::create([
                'request_id' => $requestModel->id,
                'text' => $request->get('text') ?? '',
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('orders')->with('success', 'Ваше предложение было отправлено!');
        }

        return redirect()->route('orders')->with('success', 'Ваше предложение было отправлено!');
    }
}
