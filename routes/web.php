<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Auth;
use App\Enum\User\UserRoleEnum;
use App\Http\Controllers\ProfileController;


Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('home');
Route::get('/login', [\App\Http\Controllers\MainController::class, 'showLoginForm'])->name('login.page');
Route::get('/register', [\App\Http\Controllers\MainController::class, 'showRegistrationForm'])->name('register.page');
Route::post('/login', [\App\Http\Controllers\MainController::class, 'login'])->name('login');
Route::post('/register', [\App\Http\Controllers\MainController::class, 'register'])->name('register');


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [\App\Http\Controllers\MainController::class, 'logout'])->name('logout');
    Route::get('/profile', [\App\Http\Controllers\MainController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.updateImage');

    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [ProfileController::class, 'showOrder'])->name('orders.show');
    Route::get('/profile/orders/', [ProfileController::class, 'profileOrders'])->name('profile.orders');
    Route::get('/profile/responses/', [ProfileController::class, 'responses'])->name('profile.responses');
    Route::post('/order/{id}/propose', [ProfileController::class, 'orderPropose'])->name('orders.propose');
});

// Admin
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login/form', [AdminController::class, 'loginForm'])->name('admin.login.form');


// Проверка, что пользователь авторизован и является администратором
Route::middleware(['role:' . UserRoleEnum::ADMIN])->prefix('admin')->as('admin.')->group(function () {

    // Главная страница для администратора
    Route::get('/', [AdminController::class, 'index'])->name('index');


    // Страница пользователей
    Route::get('/users', [UserController::class, 'index'])->name('users');

    // Страница транзакций
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');

    // Страница заказов
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    // Страница настроек
    Route::get('//settings', [SettingController::class, 'index'])->name('settings');
});
