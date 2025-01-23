<?php
// app/Repositories/TransactionRepository.php
namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository implements RepositoryInterface
{
    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function update(array $data, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($data);
        return $transaction;
    }

    public function delete($id)
    {
        return Transaction::destroy($id);
    }

    public function findById($id)
    {
        return Transaction::findOrFail($id);
    }

    public function findFirst()
    {
        return Transaction::first();
    }

    public function getAll()
    {
        return Transaction::all();
    }

    public function paginate($perPage = 15)
    {
        return Transaction::paginate($perPage);
    }
}
