<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Проверка, что пользователь авторизован и имеет роль ADMIN
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }


        // Перенаправление на домашнюю страницу или страницу ошибки, если роль не совпадает
        return redirect()->route('admin.login');
    }
}
