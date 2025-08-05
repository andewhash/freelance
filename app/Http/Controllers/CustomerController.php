<?php

namespace App\Http\Controllers;

use App\Enum\Order\OrderStatusEnum;
use App\Models\Order;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

class CustomerController extends Controller
{
    public function workplace()
    {
        $requests = Request::query()->orderByDesc('id')->get()->sortByDesc('created_at');

        return view('customer.workplace', compact('requests'));
    }

    public function createOrder(HttpRequest $request)
    {
        $order = Order::create([
            'seller_id' => $request->seller_id,
            'customer_id' => auth()->id(),
            'price' => 0,
            'country' => $request->country,
            'commission_price' => $request->price,
            'title' => $request->title,
            'description' => $request->description,
            'count_days' => $request->count_days,
            'status' => OrderStatusEnum::WAITING_PAYMENT
        ]);

        return redirect()->route('profile.orders');
    }
}
