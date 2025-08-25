<?php

use App\Http\Controllers\Admin\PaidFeatureController;
use App\Http\Controllers\AdPositionController;
use App\Http\Controllers\BannerAdController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PaidServicesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Seller\ResponseController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Auth;
use App\Enum\User\UserRoleEnum;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\ResponseController as AdminResponseController;
use App\Http\Controllers\ReviewController;
use App\Events\TestWebEvent;
Route::get('/web-test', function() {
    event(new TestWebEvent);
});

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('home');
// Auth Login|Register Pages
Route::get('/login', [\App\Http\Controllers\MainController::class, 'showLoginForm'])->name('login.page');
Route::get('/register', [\App\Http\Controllers\MainController::class, 'showRegistrationForm'])->name('register.page');
Route::post('/login', [\App\Http\Controllers\MainController::class, 'login'])->name('login');
Route::post('/register', [\App\Http\Controllers\MainController::class, 'register'])->name('register');

Route::get('/tarifs', [MainController::class, 'tarifs']);

// Main Pages
Route::get('/companies', action: [MainController::class, 'catalog'])->name('companies.catalog');
Route::get('/companies/{company}', [MainController::class, 'catalogShow'])->name('companies.show');

// Requests
Route::get('/requests', [MainController::class, 'requestsCatalog'])->name('requests.catalog');
Route::get('/requests/{request}', [MainController::class, 'requestsShow'])->name('requests.show');

// Responses
Route::get('/responses', [MainController::class, 'responsesCatalog'])->name('responses.catalog');
Route::get('/responses/{response}', [MainController::class, 'responsesShow'])->name('responses.show');

Route::middleware(['auth'])->group(function() {
    Route::get('/verification', [\App\Http\Controllers\MainController::class, 'showVerificationForm'])->name('verification');
    Route::post('/verify-email', [\App\Http\Controllers\MainController::class, 'verifyEmail'])->name('verify.email');
    Route::post('/verify-phone', [\App\Http\Controllers\MainController::class, 'verifyPhone'])->name('verify.phone');
    Route::post('/resend-email-code', [\App\Http\Controllers\MainController::class, 'resendEmailCode'])->name('resend.email');
    Route::post('/resend-phone-verification', [\App\Http\Controllers\MainController::class, 'resendPhoneVerification'])->name('resend.phone');
    Route::post('/change-email', [\App\Http\Controllers\MainController::class, 'changeEmail'])->name('change.email');
    Route::post('/change-phone', [\App\Http\Controllers\MainController::class, 'changePhone'])->name('change.phone');

    // Auth Logout
    Route::get('/logout', [\App\Http\Controllers\MainController::class, 'logout'])->name('logout');
});

// Auth Pages
Route::middleware(['auth', 'verified'])->group(function () {
    // Платежи
    Route::post('/payment/robokassa', [PaymentController::class, 'robokassa'])->name('payment.robokassa');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
    Route::post('/payment/result', [PaymentController::class, 'result'])->name('payment.result');

    // Запрос на проверку компании
    Route::post('/verify-request', [PaidServicesController::class, 'verifyRequest'])->name('paid-services.verify-request');
        
    // Баннерная реклама
    Route::get('/banner', [BannerAdController::class, 'create'])->name('paid-services.banner');
    Route::post('/banner', [BannerAdController::class, 'store'])->name('paid-services.banner.store');

    // Реклама в поиске
    Route::post('/bid-search', [AdPositionController::class, 'bidSearch'])->name('paid-services.bid-search');

    // Реклама в каталоге
    Route::post('/bid-catalog', [AdPositionController::class, 'bidCatalog'])->name('paid-services.bid-catalog');

    // Подписка "Я первый"
    Route::post('/premium-subscription', [SubscriptionController::class, 'activatePremium'])->name('paid-services.premium-subscription');

    //  Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/company', [ProfileController::class, 'updateCompany'])->name('profile.updateCompany');
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.updateImage');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Chats
    Route::prefix('profile/chats')->group(function () {
        Route::get('/{chat}/new-messages', [ChatController::class, 'getNewMessages'])
    ->name('profile.chats.newMessages');
        Route::get('/', [ChatController::class, 'index'])->name('profile.chats');
        Route::post('/', [ChatController::class, 'store'])->name('profile.chats.store');
        Route::post('/{chat}/send', [ChatController::class, 'send'])->name('profile.chats.send');
        Route::get('/load-more', [ChatController::class, 'loadMoreChats'])->name('profile.chats.loadMore');
        Route::get('/{chat}/load-more-messages', [ChatController::class, 'loadMoreMessages'])->name('profile.chats.loadMoreMessages');
        Route::get('/{chat}', [ChatController::class, 'getChat'])->name('profile.chats.getChat');
    });

    // Customer
    Route::group(['prefix' => 'customer/', 'as' => 'customer.'], function () {
        // Requests create update
        Route::resource('requests', \App\Http\Controllers\Customer\RequestController::class)->except(['show']);
        Route::get('requests/{request}/responses', [\App\Http\Controllers\Customer\RequestController::class, 'responses'])->name('requests.responses');
        Route::post('requests/{request}/responses/{response}/accept', [\App\Http\Controllers\Customer\RequestController::class, 'accept'])->name('requests.accept');
    });

    // Customer
    Route::group(['prefix' => 'seller/', 'as' => 'seller.'], function () {
        // Requests create update
        Route::resource('responses', \App\Http\Controllers\Seller\ResponseController::class);
        Route::delete('responses/{response}/images/{image}', [\App\Http\Controllers\Seller\ResponseController::class, 'destroyImage'])
            ->name('seller.responses.images.destroy');
        Route::get('responses/{response}/images', [\App\Http\Controllers\Seller\ResponseController::class, 'getImages'])
            ->name('seller.responses.images');
    });

    // Отзывы
    Route::prefix('reviews')->group(function () {
        Route::get('/user/{user}/create', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/user/{user}', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/user/{user}', [ReviewController::class, 'getUserReviews'])->name('reviews.user');
    });
});

// Admin
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login/form', [AdminController::class, 'loginForm'])->name('admin.login.form');


// Проверка, что пользователь авторизован и является администратором
Route::middleware(['role:' . UserRoleEnum::ADMIN])->prefix('admin')->as('admin.')->group(function () {
    // Главная админки
    Route::get('/', [AdminController::class, 'index'])->name('index');
        
    // Управление пользователями
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Управление заявками
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{request}', [RequestController::class, 'show'])->name('requests.show');
    Route::delete('/requests/{request}', [AdminController::class, 'deleteRequest'])->name('requests.delete');

    // Управление объявлениями
    Route::get('/responses', [AdminResponseController::class, 'index'])->name('responses.index');
    Route::get('/responses/{response}', [AdminResponseController::class, 'show'])->name('responses.show');
    Route::delete('/responses/{response}', [AdminController::class, 'deleteResponse'])->name('responses.delete');
    // Страница транзакций
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');

    Route::get('/paid-features', [PaidFeatureController::class, 'index'])->name('paid-features.index');
    Route::post('/paid-features/{id}/confirm', [PaidFeatureController::class, 'confirm'])->name('paid-features.confirm');
});
