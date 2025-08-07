<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Seller\ResponseController;
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
// Auth Login|Register Pages
Route::get('/login', [\App\Http\Controllers\MainController::class, 'showLoginForm'])->name('login.page');
Route::get('/register', [\App\Http\Controllers\MainController::class, 'showRegistrationForm'])->name('register.page');
Route::post('/login', [\App\Http\Controllers\MainController::class, 'login'])->name('login');
Route::post('/register', [\App\Http\Controllers\MainController::class, 'register'])->name('register');

// Main Pages
Route::get('/companies', action: [MainController::class, 'catalog'])->name('companies.catalog');
Route::get('/companies/{company}', [MainController::class, 'catalogShow'])->name('companies.show');

// Requests
Route::get('/requests', [MainController::class, 'requestsCatalog'])->name('requests.catalog');
Route::get('/requests/{request}', [MainController::class, 'requestsShow'])->name('requests.show');

// Responses
Route::get('/responses', [MainController::class, 'responsesCatalog'])->name('responses.catalog');
Route::get('/responses/{response}', [MainController::class, 'responsesShow'])->name('responses.show');

// Auth Pages
Route::middleware(['auth'])->group(function () {
    // Auth Logout
    Route::get('/logout', [\App\Http\Controllers\MainController::class, 'logout'])->name('logout');
    
    //  Profile
    Route::get('/profile', [\App\Http\Controllers\MainController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.updateImage');

    // Requests V2
    // Route::get('/requests', [ProfileController::class, 'requests'])->name('orders');
    // Route::get('/requests/{request}', [ProfileController::class, 'showRequests'])->name('orders.show');
    
    // Responses V2
    // Route::get('/profile/responses/', [ProfileController::class, 'responses'])->name('profile.responses');

    // Orders V2 
    // Route::get('/profile/orders/', [ProfileController::class, 'profileOrders'])->name('profile.orders');
    // Route::post('/order/{id}/propose', [ProfileController::class, 'orderPropose'])->name('orders.propose');
    // Route::post('/profile/orders/update', [ProfileController::class, 'updateStatus'])->name('profile.orders.update');

    // Chats
    Route::get('/chats', [ChatController::class, 'index'])->name('profile.chats');
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('profile.chats.show');
    Route::post('/chats/{chat}/send', [ChatController::class, 'send'])->name('profile.chats.send');

    // Customer
    Route::group(['prefix' => 'customer/', 'as' => 'customer.'], function () {
        // Requests create update
        Route::resource('requests', \App\Http\Controllers\Customer\RequestController::class)->except(['show']);
        Route::get('requests/{request}/responses', [\App\Http\Controllers\Customer\RequestController::class, 'responses'])->name('requests.responses');
        Route::post('requests/{request}/responses/{response}/accept', [\App\Http\Controllers\Customer\RequestController::class, 'accept'])->name('requests.accept');

        // Orders V2
        // Route::get('/orders/create', [\App\Http\Controllers\CustomerController::class, 'createOrder'])->name('orders.create');
    });

    // Customer
    Route::group(['prefix' => 'seller/', 'as' => 'seller.'], function () {
        // Requests create update
        Route::resource('responses', ResponseController::class)->except(['show']);
        // Orders V2
        // Route::get('/orders/create', [\App\Http\Controllers\CustomerController::class, 'createOrder'])->name('orders.create');
    });
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
