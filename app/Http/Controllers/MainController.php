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

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function profile()
    {
        return view ('profile.index');
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
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:CUSTOMER,SELLER',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'contact_email'=> $request->email,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Сохранение выбранной роли
        ]);

        Auth::login($user);

        return redirect()->route('profile'); // Переход на страницу после успешной регистрации
    }


        // Для Заявок
    public function requestsCatalog()
    {
        // Аналогично companies.catalog, но для модели Order
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
        
        $query = ModelRequest::query()->with('categoryLink');
        
        // Фильтры
        if ($categoryId) {
            $query->where('category', $categoryId);
        }
        
        if ($countries = request('country')) {
            $query->whereIn('country', $countries);
        }
        
        $orders = $query->paginate(12);
        
        $countries = ['Узбекистан']; // Или из базы данных
        $filterCategories = Category::whereHas('requests')->get();
        
        return view('requests.catalog', compact(
            'orders', 
            'countries', 
            'filterCategories',
            'breadcrumbs',
            'currentCategory'
        ));
    }

    public function requestsShow(ModelRequest $order)
    {
        $order->load('customer');
        return view('requests.show', compact('order'));
    }

    // Для Объявлений
    public function responsesCatalog()
    {
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
        
        $query = Response::query()->with('user', 'category');
        
        // Фильтры
        if ($categoryId) {
            $query->where('category', $categoryId);
        }
        
        $responses = $query->paginate(12);
        
        $countries = ['Узбекистан']; // Или из базы данных
        $filterCategories = Category::whereHas('responses')->get();
        
        return view('responses.catalog', compact(
            'responses', 
            'countries', 
            'filterCategories',
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
