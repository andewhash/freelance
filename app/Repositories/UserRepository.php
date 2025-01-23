<?php
// app/Repositories/UserRepository.php
namespace App\Repositories;

use App\Models\User;

class UserRepository implements RepositoryInterface
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(array $data, $id)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function findFirst()
    {
        return User::first();
    }

    public function getAll()
    {
        return User::all();
    }

    public function paginate($perPage = 15)
    {
        return User::paginate($perPage);
    }
}
