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

class MainController extends Controller
{
    public function index()
    {
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

    public function catalog()
{
    // Получаем выбранную категорию и строим хлебные крошки
    $categoryId = request('category');
    $breadcrumbs = [];
    $currentCategory = null;
    
    if ($categoryId) {
        $currentCategory = Category::with('ancestors')->find($categoryId);
        if ($currentCategory) {
            $breadcrumbs = $currentCategory->ancestors->map(function($item) {
                return ['id' => $item->id, 'name' => $item->name];
            })->toArray();
            $breadcrumbs[] = ['id' => $currentCategory->id, 'name' => $currentCategory->name];
        }
    }
    
    // Получаем компании с фильтрами
    $query = User::where('role', 'company')->with('categories');
    
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
    
    $companies = $query->paginate(12);
    
    // Получаем страны и категории для фильтров
    $countries = ['Узбекистан'];
    
    $filterCategories = Category::whereHas('users')
        ->withCount(['users' => function($q) {
            
        }])
        ->get();
    
    return view('companies.catalog', compact(
        'companies', 
        'countries', 
        'filterCategories',
        'breadcrumbs',
        'currentCategory'
    ));
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
        $phoneCode = rand(100000, 999999);

        $user = User::create([
            'contact_email' => $request->email,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verification_code' => $emailCode,
            'phone_verification_code' => $phoneCode,
        ]);

        // Отправка кода на email
        Mail::to($user->email)->send(new RegistrationEmail($user));

        // Здесь должен быть код для отправки SMS с $phoneCode
        // Например через сервис sms.ru или другой SMS-шлюз

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
        return view('auth.verification');
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
        $request->validate(['code' => 'required|digits:6']);

        $user = User::find(session('verifying_user_id'));

        if ($user->phone_verification_code == $request->code) {
            $user->update([
                'phone_verified_at' => now(),
                'phone_verification_code' => null
            ]);

            Auth::login($user);
            session()->forget('verifying_user_id');

            return redirect()->route('profile');
        }

        return back()->withErrors(['code' => 'Неверный код подтверждения']);
    }

    public function requestsCatalog()
    {
        $categoryIds = request('categories', []);
        $countryIds = request('countries', []);
        $searchQuery = request('search');
        $breadcrumbs = [];
        
        $query = ModelRequest::query()->with('categories', 'countries');
        
        // Фильтр по категориям (мультиселект)
        if (!empty($categoryIds)) {
            $query->whereHas('categories', function($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }
        
        // Фильтр по странам (через связь many-to-many)
        if (!empty($countryIds)) {
            $query->whereHas('countries', function($q) use ($countryIds) {
                $q->whereIn('countries.id', $countryIds);
            });
        }
        
        // Поиск по тексту или заголовку
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('description', 'like', "%{$searchQuery}%")
                  ->orWhere('title', 'like', "%{$searchQuery}%");
            });
        }
        
        $requests = $query->paginate(12);
        
        $allCountries = Country::get(); // Или ваш источник данных по странам
        $allCategories = Category::get();
        
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
    public function requestsShow(ModelRequest $order)
    {
        $order->load('customer');
        return view('requests.show', compact('order'));
    }

    public function responsesCatalog()
    {
        $categoryIds = request('categories', []);
        $countryIds = request('countries', []);
        $searchQuery = request('search');
        $breadcrumbs = [];
        
        $query = Response::query()->with('user', 'category', 'countries', 'images');
        
        // Фильтр по категориям (мультиселект)
        if (!empty($categoryIds)) {
            $query->whereHas('categories', function($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }
        
        // Фильтр по странам (через связь many-to-many)
        if (!empty($countryIds)) {
            $query->whereHas('countries', function($q) use ($countryIds) {
                $q->whereIn('countries.id', $countryIds);
            });
        }
        
        // Поиск по тексту или заголовку
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('text', 'like', "%{$searchQuery}%")
                ->orWhere('title', 'like', "%{$searchQuery}%");
            });
        }
        
        $responses = $query->paginate(12);
        
        $allCountries = Country::get();
        $allCategories = Category::get();
        
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

    public function responsesShow(Response $response)
    {
        $response->load('user');
        return view('responses.show', compact('response'));
    }
}
