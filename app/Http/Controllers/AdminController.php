<?php

namespace App\Http\Controllers;



use App\Models\Request;
use App\Models\Response;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Auth;
class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'totalEarnings' => Transaction::where('status', 'completed')->sum('amount'),
            'totalUsers' => User::count(),
            'totalTransactions' => Transaction::count(),
            'totalRequests' => Request::count(),
            'totalResponses' => Response::count(),
            'recentTransactions' => Transaction::with('user')->latest()->take(5)->get(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentRequests' => Request::with('customer')->latest()->take(5)->get(),
            'recentResponses' => Response::with('user')->latest()->take(5)->get()
        ];

        return view('admin.index', $stats);
    }

    public function deleteUser(User $user)
    {
        if ($user->role == 'admin') {
            
        }

        DB::transaction(function () use ($user) {
            // Удаляем связанные данные
            $user->transactions()->delete();
            $user->requests()->delete();
            $user->responses()->delete();
            
            // Удаляем самого пользователя
            $user->delete();
        });

        return back()->with('success', 'Пользователь и все связанные данные успешно удалены');
    }

    public function deleteRequest(Request $request)
    {
        DB::transaction(function () use ($request) {
            // Удаляем связанные отклики
            $request->responses()->delete();
            // Удаляем саму заявку
            $request->delete();
        });

        return back()->with('success', 'Заявка и все связанные отклики успешно удалены');
    }

    public function deleteResponse(Response $response)
    {
        $response->delete();
        return back()->with('success', 'Объявление успешно удалено');
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
