<?php
// app/Repositories/OrderRepository.php
namespace App\Repositories;

use App\Models\Order;

class OrderRepository implements RepositoryInterface
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update(array $data, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function delete($id)
    {
        return Order::destroy($id);
    }

    public function findById($id)
    {
        return Order::findOrFail($id);
    }

    public function findFirst()
    {
        return Order::first();
    }

    public function getAll()
    {
        return Order::all();
    }

    public function paginate($perPage = 15)
    {
        return Order::paginate($perPage);
    }
}
