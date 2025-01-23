<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
use Hash;
class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::all();

        return view('admin.index', ['orders' => $orders]);
    }

    public function login()
    {
        return view ('admin.login');
    }

    public function loginForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Попытка аутентификации пользователя
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Проверка, является ли пользователь администратором
            if ($user->role === 'ADMIN') {
                // Перенаправляем админа в панель управления
                return redirect()->route('admin.index');
            }

            // В случае если роль не ADMIN, редирект на домашнюю страницу или страницу с ошибкой
            Auth::logout();
            return redirect()->route('home')->withErrors(['email' => 'You do not have admin privileges.']);
        }

        // Ошибка авторизации
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    // Метод для выхода
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
