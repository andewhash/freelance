<?php

namespace App\Http\Controllers;


use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Получаем статистику
        $totalEarnings = Transaction::where('status', 'completed')->sum('amount');
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.index', [
            'totalEarnings' => $totalEarnings,
            'totalUsers' => $totalUsers,
            'totalTransactions' => $totalTransactions,
            'recentTransactions' => $recentTransactions,
            'recentUsers' => $recentUsers
        ]);
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
