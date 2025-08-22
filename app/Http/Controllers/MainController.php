<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;
use App\Models\Request as ModelRequest;
use App\Models\Response;
use App\Models\Country;
use App\Mail\RegistrationEmail;
use Illuminate\Support\Facades\Mail;
use Http;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\RobokassaService;
use App\Models\Transaction;
use DB;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $robokassaService = new RobokassaService();
        if ($request->has('InvId')) {
            $invId = $request->InvId;
            $outSum = $request->OutSum;
            $signature = $request->SignatureValue;
            $isTest = $request->IsTest;
    
            // Ищем транзакцию по system = robokassa_{InvId}
            $transaction = Transaction::where('system', 'robokassa_'.$invId)->first();
    
            if (!$transaction) {
                \Log::error("Transaction not found for InvId: {$invId}");
                return response('Transaction not found', 404);
            }
    
            // Проверяем сумму
            if ((float)$outSum != (float)$transaction->amount) {
                \Log::error("Amount mismatch for transaction {$transaction->id}");
                return response('Amount mismatch', 400);
            }
    
            // Валидируем подпись
            if (!$robokassaService->validateSuccessSignature($outSum, $invId, $signature, $isTest)) {
                \Log::error("Invalid signature for transaction {$transaction->id}");
                return response('Invalid signature', 400);
            }
    
            // Если транзакция уже обработана
            if ($transaction->status === 'COMPLETED') {
                return redirect('/profile');
            }
    
            // Обновляем баланс пользователя
            try {
                DB::transaction(function () use ($transaction, $outSum) {
                    $user = User::findOrFail($transaction->user_id);
                    
                    $user->increment('balance', $outSum);
                    $transaction->update(['status' => 'COMPLETED']);
                    
                    \Log::info("Balance updated for user {$user->id}. Amount: {$outSum}");
                });
                
                return redirect('/profile');
            } catch (\Exception $e) {
                \Log::error("Error processing payment: " . $e->getMessage());
                return redirect('/profile');
            }
        }
    
        return view('index');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('profile'); // Переход на страницу после успешного логина
        }

        return back()->withErrors(['email' => 'Неверные данные для входа.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }


    public function catalogShow(User $user)
    {

        $user->load('categories', 'orders', 'chats');
        return view('companies.show', compact('user'));
    }

    public function tarifs()
    {
        return view('tarifs');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:CUSTOMER,SELLER',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Генерация кодов верификации
        $emailCode = rand(100000, 999999);
        // Отправляем запрос на call-верификацию
        $response = Http::get('https://sms.ru/callcheck/add', [
            'api_id' => '46407EDC-7206-7930-20AC-2F3E787F5F19',
            'phone' => $request->phone,
            'json' => 1
        ]);

        $callData = $response->json();
        
        if ($callData['status'] !== 'OK') {
            return back()->withErrors(['phone' => __('Укажите верный номер телефона')])->withInput();
        }

        $user = User::create([
            'contact_email' => $request->email,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verification_code' => $emailCode,
            'phone_verification_code' => $callData['call_phone_pretty'].'__'.$callData['check_id'],
        ]);

        // Отправка кода на email
        Mail::to($user->email)->send(new RegistrationEmail($user));

        // Сохраняем ID пользователя в сессии для верификации
        session(['verifying_user_id' => $user->id]);
        Auth::login($user);
        return redirect()->route('verification');
    }

    public function showVerificationForm()
    {
        if (!session()->has('verifying_user_id') && !auth()->user()) {
            return redirect()->route('register');
        }
        
        $user = auth()->user();
        
        if ($user->email_verified_at && $user->phone_verified_at) {
            return redirect('/profile');
        }
        $emailResendAvailable = RateLimiter::remaining('email-resend:'.$user->id, 3);
        $phoneResendAvailable = RateLimiter::remaining('phone-resend:'.$user->id, 3);
        
        return view('auth.verification', compact('emailResendAvailable', 'phoneResendAvailable'));
    }

    public function resendEmailCode(Request $request)
    {
        $user = auth()->user();
        
        // Проверка CAPTCHA
        $request->validate([
            // 'captcha' => 'required|captcha'
        ]);
        
        // Ограничение частоты запросов
        if (RateLimiter::tooManyAttempts('email-resend:'.$user->id, 3)) {
            $seconds = RateLimiter::availableIn('email-resend:'.$user->id);
            return back()->withErrors(['email' => "Повторная отправка будет доступна через {$seconds} секунд"]);
        }
        
        RateLimiter::hit('email-resend:'.$user->id);
        
        $emailCode = rand(100000, 999999);
        $user->update([
            'email_verification_code' => $emailCode,
            'email_verified_at' => null
        ]);
        
        Mail::to($user->email)->send(new RegistrationEmail($user));
        
        return back()->with('success', 'Новый код подтверждения отправлен на ваш email');
    }

    public function changeEmail(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            // 'captcha' => 'required|captcha'
        ]);
        
        // Ограничение частоты смены email
        if (RateLimiter::tooManyAttempts('email-change:'.$user->id, 1)) {
            $seconds = RateLimiter::availableIn('email-change:'.$user->id);
            return back()->withErrors(['email' => "Смена email будет доступна через {$seconds} секунд"]);
        }
        
        RateLimiter::hit('email-change:'.$user->id, 60); // 1 минута
        
        $emailCode = rand(100000, 999999);
        $user->update([
            'email' => $request->email,
            'email_verification_code' => $emailCode,
            'email_verified_at' => null
        ]);
        
        Mail::to($user->email)->send(new RegistrationEmail($user));
        
        return back()->with('success', 'На новый email отправлен код подтверждения');
    }

    public function resendPhoneVerification(Request $request)
    {
        $user = auth()->user();
        
        // Проверка CAPTCHA
        $request->validate([
            // 'captcha' => 'required|captcha'
        ]);
        
        // Ограничение частоты запросов
        if (RateLimiter::tooManyAttempts('phone-resend:'.$user->id, 3)) {
            $seconds = RateLimiter::availableIn('phone-resend:'.$user->id);
            return back()->withErrors(['phone' => "Повторная отправка будет доступна через {$seconds} секунд"]);
        }
        
        RateLimiter::hit('phone-resend:'.$user->id);
        
        $response = Http::get('https://sms.ru/callcheck/add', [
            'api_id' => '46407EDC-7206-7930-20AC-2F3E787F5F19',
            'phone' => $user->phone,
            'json' => 1
        ]);

        $callData = $response->json();
        
        if ($callData['status'] !== 'OK') {
            return back()->withErrors(['phone' => 'Ошибка при запросе call-верификации']);
        }
        
        $user->update([
            'phone_verification_code' => $callData['call_phone_pretty'].'__'.$callData['check_id'],
            'phone_verified_at' => null
        ]);
        
        return back()->with('success', 'Новый номер для звонка сгенерирован');
    }

    public function changePhone(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'phone' => 'required|unique:users,phone,'.$user->id,
            // 'captcha' => 'required|captcha'
        ]);
        
        // Ограничение частоты смены телефона
        if (RateLimiter::tooManyAttempts('phone-change:'.$user->id, 1)) {
            $seconds = RateLimiter::availableIn('phone-change:'.$user->id);
            return back()->withErrors(['phone' => "Смена телефона будет доступна через {$seconds} секунд"]);
        }
        
        RateLimiter::hit('phone-change:'.$user->id, 180); // 3 минуты
        
        $response = Http::get('https://sms.ru/callcheck/add', [
            'api_id' => '46407EDC-7206-7930-20AC-2F3E787F5F19',
            'phone' => $request->phone,
            'json' => 1
        ]);

        $callData = $response->json();
        
        if ($callData['status'] !== 'OK') {
            return back()->withErrors(['phone' => 'Укажите верный номер телефона']);
        }
        
        $user->update([
            'phone' => $request->phone,
            'phone_verification_code' => $callData['call_phone_pretty'].'__'.$callData['check_id'],
            'phone_verified_at' => null
        ]);
        
        return back()->with('success', 'На новый номер отправлен запрос call-верификации');
    }


    public function verifyEmail(Request $request)
    {
        $user = auth()->user();
        // $request->validate(['code' => 'required|digits:6']);

        // $user = User::find(session('verifying_user_id'));

        if (!$user) {
            $user = auth()->user();
        } 

        if ($user->email_verification_code == $request->code) {
            $user->update([
                'email_verified_at' => now(),
                'email_verification_code' => null
            ]);

            return redirect()->route('verification');
        }

        return back()->withErrors(['code' => 'Неверный код подтверждения']);
    }

    public function verifyPhone(Request $request)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('register');
        }

        // Разделяем сохраненные данные
        $phoneVerificationData = explode('__', $user->phone_verification_code);
        $checkId = end($phoneVerificationData);

        // Проверяем статус звонка
        $response = Http::get('https://sms.ru/callcheck/status', [
            'api_id' => '46407EDC-7206-7930-20AC-2F3E787F5F19',
            'check_id' => $checkId,
            'json' => 1
        ]);

        $statusData = $response->json();

        if ($statusData['status'] === 'OK' && $statusData['check_status'] == '401') {
            $user->update([
                'phone_verified_at' => now(),
                'phone_verification_code' => null
            ]);

            Auth::login($user);
            session()->forget('verifying_user_id');

            return redirect()->route('profile');
        }

        return back()->withErrors(['phone' => 'Звонок не подтвержден. Пожалуйста, позвоните на указанный номер.']);
    }

    public function requestsCatalog()
{
    $categoryIds = request('categories', []);
    $countryIds = request('countries', []);
    $searchQuery = request('search');
    $breadcrumbs = [];
    
    $query = ModelRequest::query()
        ->select('requests.*')
        ->with(['categories', 'countries'])
        ->join('users', 'requests.customer_id', '=', 'users.id')
        ->orderBy('users.order_search', 'desc')
        ->orderBy('requests.created_at', 'desc');
    
    $user = auth()->user();
    $hasPremium = $user && $user->has_premium_subscription == 1;
    if (!$hasPremium) {
        $query->where('requests.created_at', '<=', now()->subHour());
    }
    
    // Фильтр по категориям
    if (!empty($categoryIds)) {
        $query->whereHas('categories', function($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        });
    }
    
    // Фильтр по странам
    if (!empty($countryIds)) {
        $query->whereHas('countries', function($q) use ($countryIds) {
            $q->whereIn('countries.id', $countryIds);
        });
    }
    
    // Поиск
    if ($searchQuery) {
        $searchTerms = array_filter(explode(' ', $searchQuery));
        
        if (!empty($searchTerms)) {
            $query->where(function($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    if (strlen($term) > 2) {
                        $q->orWhere('requests.title', 'like', "%{$term}%")
                        ->orWhere('requests.description', 'like', "%{$term}%")
                        ->orWhereHas('categories', function($catQuery) use ($term) {
                            $catQuery->where('name', 'like', "%{$term}%");
                        })
                        ->orWhereHas('countries', function($countryQuery) use ($term) {
                            $countryQuery->where('name', 'like', "%{$term}%");
                        })
                        ->orWhereHas('user', function($userQuery) use ($term) {
                            $userQuery->where('name', 'like', "%{$term}%");
                        });
                    }
                }
            });
        }
    }
    
    $requests = $query->paginate(12);
    
    // Получаем иерархические категории
    $allCategories = Category::getHierarchicalForCheckboxes();
    $allCountries = Country::all();
    
    return view('requests.catalog', compact(
        'requests', 
        'allCountries', 
        'allCategories',
        'breadcrumbs',
        'searchQuery',
        'categoryIds',
        'countryIds'
    ));
}
    public function requestsShow($orderId)
    {
        $order = ModelRequest::findOrFail($orderId);
        $order->load('customer');
        
        return view('requests.show', compact('order'));
    }

    public function responsesCatalog()
    {
        $categoryIds = request('categories', []);
        $countryIds = request('countries', []);
        $searchQuery = request('search');
        $breadcrumbs = [];
        
        $query = Response::query()
            ->select('responses.*')
            ->with(['user', 'categories', 'countries', 'images'])
            ->join('users', 'responses.user_id', '=', 'users.id')
            ->orderBy('users.order_search', 'desc')
            ->orderBy('responses.created_at', 'desc');
        
        // Фильтр по категориям
        if (!empty($categoryIds)) {
            $query->whereHas('categories', function($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }
        
        // Фильтр по странам
        if (!empty($countryIds)) {
            $query->whereHas('countries', function($q) use ($countryIds) {
                $q->whereIn('countries.id', $countryIds);
            });
        }
        
        // Поиск
        if ($searchQuery) {
            $searchTerms = array_filter(explode(' ', $searchQuery));
            
            if (!empty($searchTerms)) {
                $query->where(function($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        if (strlen($term) > 2) {
                            $q->orWhere('responses.title', 'like', "%{$term}%")
                            ->orWhere('responses.text', 'like', "%{$term}%")
                            ->orWhereHas('categories', function($catQuery) use ($term) {
                                $catQuery->where('name', 'like', "%{$term}%");
                            })
                            ->orWhereHas('countries', function($countryQuery) use ($term) {
                                $countryQuery->where('name', 'like', "%{$term}%");
                            })
                            ->orWhereHas('user', function($userQuery) use ($term) {
                                $userQuery->where('name', 'like', "%{$term}%");
                            });
                        }
                    }
                });
            }
        }
        
        $responses = $query->paginate(12);
        
        // Получаем иерархические категории
        $allCategories = Category::getHierarchicalForCheckboxes();
        $allCountries = Country::all();
        
        return view('responses.catalog', compact(
            'responses', 
            'allCountries', 
            'allCategories',
            'breadcrumbs',
            'searchQuery',
            'categoryIds',
            'countryIds'
        ));
    }

    public function catalog()
{
    // Получаем выбранную категорию и строим хлебные крошки
    $categoryId = request('category');
    $breadcrumbs = [];
    $currentCategory = null;
    $categoryIds = request('categories', []);
    $countryIds = request('countries', []);
    $verifiedOnly = request('verified', false);
    if ($categoryId) {
        $currentCategory = Category::with('ancestors')->find($categoryId);
        if ($currentCategory) {
            $breadcrumbs = $currentCategory->ancestors->reverse()->map(function($item) {
                return ['id' => $item->id, 'name' => $item->name];
            })->toArray();
            $breadcrumbs[] = ['id' => $currentCategory->id, 'name' => $currentCategory->name];
        }
    }
    
    // Получаем компании с фильтрами
    $query = User::where('role', 'company')
                ->with('categories')
                ->orderBy('order_catalog', 'desc') // Сортировка по order_catalog (чем больше - тем выше)
                ->orderBy('created_at', 'desc'); // Затем по дате создания (новые выше)
    
    // Фильтр по категории
    if ($categoryId) {
        $query->whereHas('categories', function($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }
    
    // Фильтр по странам
    if ($countries = request('country')) {
        $query->whereIn('country', function($q) use ($countries) {
            $q->select('name')->from('countries')->whereIn('id', $countries);
        });
    }
    
    // Фильтр по категориям
    if ($categories = request('category')) {
        $query->whereHas('categories', function($q) use ($categories) {
            $q->where('categories.id', $categories);
        });
    }
     if ($verifiedOnly) {
        $query->where('is_verified_inn', true);
    }
    
    $companies = $query->paginate(12);
    
    // Получаем страны и категории для фильтров
    $allCountries = Country::get(); // Или ваш источник данных по странам
    $allCategories = Category::whereHas('parent', function($query) {
        $query->whereHas('parent');
    })->get();
    
    return view('companies.catalog', compact(
        'companies', 
        'allCategories', 
        'allCountries',
        'categoryIds',
        'countryIds',
        'breadcrumbs',
        'currentCategory'
    ));
}

    public function responsesShow(Response $response)
    {
        $response->load('user');
        return view('responses.show', compact('response'));
    }
}
