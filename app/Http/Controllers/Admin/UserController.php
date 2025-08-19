<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        $users = User::query()
            ->when($search, function (Builder $query, string $search) {
                $query->where(function($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when($role, function (Builder $query, string $role) {
                $query->where('role', $role);
            })
            ->orderBy($sort, $order)
            ->paginate(10);
        return view('admin.users', compact('users'));
    }
}
