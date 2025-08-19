<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Response;
use Illuminate\Http\Request;
use Hash;
use App\Models\Request as RequestModel;
class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $transactions = $user->transactions()->paginate(15);
        
        // Получаем позиции для рекламы в поиске
        $searchPositions = \App\Models\AdPosition::where('type', 'search')
            ->orderBy('position')
            ->take(10) // или сколько вам нужно
            ->get();
        
        // Получаем позиции для рекламы в каталоге
        $catalogPositions = \App\Models\AdPosition::where('type', 'catalog')
            ->orderBy('position')
            ->take(10) // или сколько вам нужно
            ->get();
        
        return view('profile.index', compact(
            'user',
            'transactions',
            'searchPositions',
            'catalogPositions'
        ));
    }

    public function update(Request $request)
    {
        
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'telegram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'site' => 'nullable|url|max:255',
        ]);
        
        $user->update($validated);
        
        return back()->with('success', 'Профиль успешно обновлен');
    }

    public function updateCompany(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'mark' => 'nullable|string|max:255',
            'description' => 'required|string',
            'business_type' => 'required|string|in:manufacturer,distributor,wholesaler',
            'exported' => 'required|boolean',
            'count_employers' => 'nullable|string|max:50',
            'year' => 'nullable|string|max:4',
            'categories.*' => 'exists:categories,id',
            'countries' => 'sometimes|array',
            'countries.*' => 'exists:countries,id',
        ]);
        
        $user->update($validated);

        if ($request->has('categories')) {
            $user->categories()->sync($request->categories);
        }
        
        // Синхронизация стран
        if ($request->has('countries')) {
            $user->countries()->sync($request->countries);
        }
        
        
        return back()->with('success', 'Информация о компании обновлена');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $path = $request->file('image')->store('public/avatars');
        auth()->user()->update(['image_url' => str_replace('public/', '', $path)]);
        
        return back()->with('success', 'Фотография профиля обновлена');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = auth()->user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Текущий пароль неверен']);
        }
        
        $user->update(['password' => Hash::make($request->new_password)]);
        
        return back()->with('success', 'Пароль успешно изменен');
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
