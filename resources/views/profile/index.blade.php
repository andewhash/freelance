@extends('layouts.app')

@section('content')

<div class="main-content position-relative min-height-vh-100 h-100">
    <div class="container">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('/img/background.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="card card-body mx-2 mx-md-4 mt-n6">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    <strong>Ошибка!</strong> Пожалуйста, исправьте следующие ошибки:
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/storage/{{auth()->user()->image_url}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">{{auth()->user()->name}}</h5>
                        <p class="mb-0 font-weight-normal text-sm">{{auth()->user()->email}}</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Левая колонка с вкладками -->
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab">
                            <i class="material-symbols-rounded me-2">person</i>
                            Профиль
                        </a>
                        @if(auth()->user()->role === 'SELLER')
                        <a class="nav-link" id="v-pills-company-tab" data-bs-toggle="pill" href="#v-pills-company" role="tab">
                            <i class="material-symbols-rounded me-2">business</i>
                            Компания
                        </a>
                        @endif
                        <a class="nav-link" id="v-pills-payments-tab" data-bs-toggle="pill" href="#v-pills-payments" role="tab">
                            <i class="material-symbols-rounded me-2">payments</i>
                            Платежи
                        </a>
                        <a class="nav-link" id="v-pills-paid-services-tab" data-bs-toggle="pill" href="#v-pills-paid-services" role="tab">
                            <i class="material-symbols-rounded me-2">paid</i>
                            Платные услуги
                        </a>
                        <a class="nav-link" id="v-pills-security-tab" data-bs-toggle="pill" href="#v-pills-security" role="tab">
                            <i class="material-symbols-rounded me-2">lock</i>
                            Безопасность
                        </a>
                    </div>
                </div>
                
                <!-- Правая колонка с контентом -->
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Вкладка профиля -->
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel">
                            <div class="card">
                                <div class="card-header p-3 pt-2">
                                    <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                        <i class="material-symbols-rounded opacity-10">person</i>
                                    </div>
                                    <h6 class="mb-0">Основные данные</h6>
                                </div>
                                <div class="card-body pt-0">
                                    <form action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Имя</label>
                                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Фамилия</label>
                                                    <input type="text" class="form-control" name="last_name" value="{{ auth()->user()->last_name ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label>На сайте с</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->created_at->format('Y') }}" readonly>
                                        </div>
                                        
                                        <hr class="horizontal dark">
                                        <h6 class="mb-3">Контактная информация</h6>
                                        
                                        <div class="input-group input-group-static mb-4">
                                            <label>E-mail</label>
                                            <input type="email" disabled class="form-control disabled" style="background: rgb(211, 211, 211);background-image:none !important;" value="{{ auth()->user()->email }}">
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label>Телефон</label>
                                            <input type="text" disabled class="form-control disabled"  style="background: rgb(211, 211, 211);background-image:none !important;" value="{{ auth()->user()->phone ?? '' }}">
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label>Telegram</label>
                                            <input type="text" class="form-control" name="telegram" value="{{ auth()->user()->telegram ?? '' }}">
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label>WhatsApp</label>
                                            <input type="text" class="form-control" name="whatsapp" value="{{ auth()->user()->whatsapp ?? '' }}">
                                        </div>
                                        
                                        <hr class="horizontal dark">
                                        <h6 class="mb-3">Фотография профиля</h6>
                                        
                                        <div class="d-flex align-items-center">
                                            <div class="me-4">
                                                <img src="/storage/{{ auth()->user()->image_url }}" alt="Текущая фотография" class="img-thumbnail" width="100">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="mb-3">
                                                    <label class="form-label">Загрузить новую фотографию</label>
                                                    <input type="file" class="form-control" name="image">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Вкладка компании (только для поставщиков) -->
                        @if(auth()->user()->role === 'SELLER')
                        <div class="tab-pane fade" id="v-pills-company" role="tabpanel">
                            <div class="card">
                                <div class="card-header p-3 pt-2">
                                    <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                        <i class="material-symbols-rounded opacity-10">business</i>
                                    </div>
                                    <h6 class="mb-0">Информация о компании</h6>
                                </div>
                                <div class="card-body pt-0">
                                    <form action="{{ route('profile.updateCompany') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Название компании *</label>
                                                    <input type="text" class="form-control" name="brand" value="{{ auth()->user()->brand ?? '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Торговая марка</label>
                                                    <input type="text" class="form-control" name="mark" value="{{ auth()->user()->mark ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="input-group input-group-static mb-4">
                                            <label>Описание *</label>
                                            <textarea class="form-control" name="description" rows="3" required>{{ auth()->user()->description ?? '' }}</textarea>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Тип бизнеса *</label>
                                                    <select class="form-control" name="business_type" required>
                                                        <option value="">Выберите тип</option>
                                                        <option value="manufacturer" @if(auth()->user()->business_type == 'manufacturer') selected @endif>Производитель</option>
                                                        <option value="distributor" @if(auth()->user()->business_type == 'distributor') selected @endif>Дистрибьютор</option>
                                                        <option value="wholesaler" @if(auth()->user()->business_type == 'wholesaler') selected @endif>Оптовик</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Экспортёр *</label>
                                                    <select class="form-control" name="exported" required>
                                                        <option value="0" @if(!auth()->user()->exported) selected @endif>Нет</option>
                                                        <option value="1" @if(auth()->user()->exported) selected @endif>Да</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Количество сотрудников</label>
                                                    <input type="text" class="form-control" name="count_employers" value="{{ auth()->user()->count_employers ?? '0' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Год основания</label>
                                                    <input type="text" class="form-control" name="year" value="{{ auth()->user()->year ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <hr class="horizontal dark">
                                        <h6 class="mb-3">Адрес компании</h6>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Страна</label>
                                                    <input type="text" class="form-control" name="country" value="{{ auth()->user()->country ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Область</label>
                                                    <input type="text" class="form-control" name="region" value="{{ auth()->user()->region ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Город</label>
                                                    <input type="text" class="form-control" name="city" value="{{ auth()->user()->city ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="input-group input-group-static mb-4">
                                            <label>Адрес</label>
                                            <input type="text" class="form-control" name="address" value="{{ auth()->user()->address ?? '' }}">
                                        </div>
                                        
                                        <hr class="horizontal dark">
                                        <h6 class="mb-3">Контактная информация</h6>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>E-mail</label>
                                                    <input type="email" class="form-control" name="contact_email" value="{{ auth()->user()->contact_email ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Веб-сайт</label>
                                                    <input type="text" class="form-control" name="site" value="{{ auth()->user()->site ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Телефон</label>
                                                    <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label>Telegram</label>
                                                    <input type="text" class="form-control" name="telegram" value="{{ auth()->user()->telegram ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="input-group input-group-static mb-4">
                                            <label>WhatsApp</label>
                                            <input type="text" class="form-control" name="whatsapp" value="{{ auth()->user()->whatsapp ?? '' }}">
                                        </div>
                                        
                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Вкладка платежей -->
                        <div class="tab-pane fade" id="v-pills-payments" role="tabpanel">
                            <div class="card">
                                <div class="card-header p-3 pt-2">
                                    <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                        <i class="material-symbols-rounded opacity-10">payments</i>
                                    </div>
                                    <h6 class="mb-0">Платежи и баланс</h6>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="alert main-btn-active">
                                        <strong>Текущий баланс:</strong> {{ number_format(auth()->user()->balance, 2) }} ₽
                                    </div>
                                    
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6>Пополнение баланса</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('payment.robokassa') }}" method="POST">
                                                @csrf
                                                <div class="input-group input-group-static mb-3">
                                                    <label>Сумма пополнения (₽)</label>
                                                    <input type="number" class="form-control" name="amount" min="10" step="1" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Пополнить через Robokassa</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-header">
                                            <h6>История операций</h6>
                                        </div>
                                        <div class="card-body">
                                            @if($transactions->isEmpty())
                                                <p class="text-muted">Нет операций</p>
                                            @else
                                                <div class="table-responsive">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Дата</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Сумма</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Описание</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Статус</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($transactions as $transaction)
                                                            <tr>
                                                                <td class="text-sm">{{ $transaction->created_at->format('d.m.Y H:i') }}</td>
                                                                <td class="text-sm">{{ number_format($transaction->amount, 2) }} ₽</td>
                                                                <td class="text-sm">{{ $transaction->description }}</td>
                                                                <td class="text-sm">
                                                                    @if($transaction->status === 'completed')
                                                                        <span class="badge badge-sm bg-gradient-success">Завершено</span>
                                                                    @elseif($transaction->status === 'pending')
                                                                        <span class="badge badge-sm bg-gradient-warning">В обработке</span>
                                                                    @else
                                                                        <span class="badge badge-sm bg-gradient-danger">Ошибка</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mt-3">
                                                    {{ $transactions->links() }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Вкладка платных услуг -->
                        <div class="tab-pane fade" id="v-pills-paid-services" role="tabpanel">
                            <div class="card">
                                <div class="card-header p-3 pt-2">
                                    <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                        <i class="material-symbols-rounded opacity-10">paid</i>
                                    </div>
                                    <h6 class="mb-0">Платные услуги</h6>
                                </div>
                                <div class="card-body pt-0 mt-2">
                                    <div class="row">
                                        <!-- 1. Проверка компании -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header p-3 pt-2 main-btn-active">
                                                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                                        <i class="material-symbols-rounded text-dark opacity-10">verified</i>
                                                    </div>
                                                    <h6 class="mb-0 text-white">Проверка компании</h6>
                                                </div>
                                                <div class="card-body p-3">
                                                    <p class="text-sm">Официальная проверка данных вашей компании нашими специалистами. После проверки ваш аккаунт получит статус "Проверенная компания".</p>
                                                    <ul class="list-group">
                                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Стоимость:</strong> $50</li>
                                                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Текущий статус:</strong> 
                                                            @if(auth()->user()->is_verified_company)
                                                                <span class="badge bg-gradient-success">Проверено</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Не проверено</span>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                    @if(!auth()->user()->is_verified_company)
                                                        <form action="{{ route('paid-services.verify-request') }}" method="POST" class="mt-3">
                                                            @csrf
                                                            <button type="submit" class="btn btn-another-primary mb-0">Заказать проверку</button>
                                                        </form>
                                                        @else
                                                        <button class="btn btn-another-primary mb-0 mt-3" disabled>Подписка активна</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- 2. Баннерная реклама -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header p-3 pt-2 main-btn-active">
                                                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                                        <i class="material-symbols-rounded text-dark opacity-10">ad_units</i>
                                                    </div>
                                                    <h6 class="mb-0 text-white">Баннерная реклама</h6>
                                                </div>
                                                <div class="card-body p-3">
                                                    <p class="text-sm">Размещение вашего баннера в верхней части сайта. Баннер будет показываться в выбранных категориях.</p>
                                                    <ul class="list-group">
                                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Стоимость:</strong> $100 в месяц</li>
                                                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Доступные категории:</strong> Все категории сайта</li>
                                                    </ul>
                                                    
                                                    <!-- Кнопка для открытия модального окна -->
                                                    <button type="button" class="btn btn-another-primary mb-0 mt-3" data-bs-toggle="modal" data-bs-target="#bannerModal">
                                                        Заказать баннер
                                                    </button>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Модальное окно для заказа баннера -->
                                        <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="bannerModalLabel">Заказ баннерной рекламы</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form id="bannerForm" action="{{ route('paid-services.banner.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="bannerImage" class="form-label">Изображение баннера</label>
                                                                <input class="form-control" type="file" id="bannerImage" name="image" accept="image/jpeg,image/png,image/gif" required>
                                                                <div class="form-text">Рекомендуемый размер: 1200x200px, не более 2MB</div>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label for="bannerLink" class="form-label">Ссылка</label>
                                                                <input type="url" class="form-control" id="bannerLink" name="link" placeholder="https://example.com" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label for="bannerCategories" class="form-label">Выберите категории для показа</label>
                                                                <select class="form-select" id="bannerCategories" name="categories[]" required>
                                                                    @foreach(App\Models\Category::get() as $category)
                                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="form-text">Для выбора нескольких категорий удерживайте Ctrl (Windows) или Command (Mac)</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="bannerDuration" class="form-label">Срок размещения (месяцев)</label>
                                                                <input type="number" class="form-control" id="bannerDuration" name="duration" min="1" max="12" value="1" required>
                                                                <div class="form-text">Стоимость: $<span id="bannerCost">100</span> (100$/мес)</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                            <button type="submit" class="btn btn-primary">Оплатить и разместить</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            // Обновление стоимости при изменении длительности
                                            document.getElementById('bannerDuration').addEventListener('change', function() {
                                                const duration = this.value;
                                                document.getElementById('bannerCost').textContent = 100 * duration;
                                            });
                                        </script>
                                        
                                        <!-- 3. Реклама на поиске -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header p-3 pt-2 main-btn-active">
                                                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                                        <i class="material-symbols-rounded text-dark opacity-10">search</i>
                                                    </div>
                                                    <h6 class="mb-0 text-white">Реклама в поиске</h6>
                                                </div>
                                                <div class="card-body p-3">
                                                    <p class="text-sm">Повышение позиции ваших товаров в результатах поиска. Чем выше ставка, тем выше позиция.</p>
                                                    
                                                    <div class="table-responsive">
                                                        <table class="table align-items-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Позиция</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Компания</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ставка</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $topSearch = App\Models\User::where('order_search', '>', 0)
                                                                        ->orderBy('order_search', 'DESC')
                                                                        ->take(5)
                                                                        ->get();
                                                                @endphp
                                                                
                                                                @foreach($topSearch as $index => $user)
                                                                <tr>
                                                                    <td class="text-sm">{{ $index + 1 }}</td>
                                                                    <td class="text-sm">{{ $user->company_name ?? $user->name }}</td>
                                                                    <td class="text-sm">{{ number_format($user->order_search, 2) }} ₽</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    
                                                    <form action="{{ route('paid-services.bid-search') }}" method="POST" class="mt-3">
                                                        @csrf
                                                        <div class="input-group is-focused input-group-outline mb-3">
                                                            <label class="form-label">Ваша ставка (₽)</label>
                                                            <input type="number" 
                                                                class="form-control" 
                                                                name="bid" 
                                                                min="{{ $topSearch->last() ? $topSearch->last()->order_search + 1 : 1 }}" 
                                                                value="{{ $topSearch->last() ? $topSearch->last()->order_search + 1 : 1 }}" 
                                                                required
                                                                step="1">
                                                        </div>
                                                        <small class="text-muted">Минимальная ставка: {{ $topSearch->last() ? $topSearch->last()->order_search + 1 : 1 }} ₽</small>
                                                        <button type="submit" class="btn btn-another-primary mb-0 mt-2 w-100">Сделать ставку</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- 4. Реклама в каталоге -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header p-3 pt-2 main-btn-active">
                                                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                                        <i class="material-symbols-rounded text-dark opacity-10">store</i>
                                                    </div>
                                                    <h6 class="mb-0 text-white">Реклама в каталоге</h6>
                                                </div>
                                                <div class="card-body p-3">
                                                    <p class="text-sm">Повышение позиции вашей компании в каталоге. Чем выше ставка, тем выше позиция.</p>
                                                    
                                                    <div class="table-responsive">
                                                        <table class="table align-items-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Позиция</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Компания</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ставка</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $topCatalog = App\Models\User::where('order_catalog', '>', 0)
                                                                        ->orderBy('order_catalog', 'DESC')
                                                                        ->take(5)
                                                                        ->get();
                                                                @endphp
                                                                
                                                                @foreach($topCatalog as $index => $user)
                                                                <tr>
                                                                    <td class="text-sm">{{ $index + 1 }}</td>
                                                                    <td class="text-sm">{{ $user->company_name ?? $user->name }}</td>
                                                                    <td class="text-sm">{{ number_format($user->order_catalog, 2) }} ₽</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    
                                                    <form action="{{ route('paid-services.bid-catalog') }}" method="POST" class="mt-3">
                                                        @csrf
                                                        <div class="input-group is-focused input-group-outline mb-3">
                                                            <label class="form-label">Ваша ставка (₽)</label>
                                                            <input type="number" 
                                                                class="form-control" 
                                                                name="bid" 
                                                                min="{{ $topCatalog->last() ? $topCatalog->last()->order_catalog + 1 : 1 }}" 
                                                                value="{{ $topCatalog->last() ? $topCatalog->last()->order_catalog + 1 : 1 }}" 
                                                                required
                                                                step="1">
                                                        </div>
                                                        <small class="text-muted">Минимальная ставка: {{ $topCatalog->last() ? $topCatalog->last()->order_catalog + 1 : 1 }} ₽</small>
                                                        <button type="submit" class="btn btn-another-primary mb-0 mt-2 w-100">Сделать ставку</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- 5. Выездная проверка -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header p-3 pt-2 main-btn-active">
                                                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                                        <i class="material-symbols-rounded text-dark opacity-10">home_work</i>
                                                    </div>
                                                    <h6 class="mb-0 text-white">Выездная проверка</h6>
                                                </div>
                                                <div class="card-body p-3">
                                                    <p class="text-sm">Наш специалист посетит вашу компанию для проведения профессиональной проверки и составления отчета.</p>
                                                    <ul class="list-group">
                                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Стоимость:</strong> $100</li>
                                                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Длительность:</strong> 2-3 рабочих дня</li>
                                                    </ul>
                                                    <button class="btn btn-outline-dark mb-0 mt-3" disabled>Скоро будет доступно</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- 6. Подписка "Я первый" -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header p-3 pt-2 main-btn-active">
                                                    <div class="icon icon-lg icon-shape bg-white shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                                        <i class="material-symbols-rounded text-dark opacity-10">priority</i>
                                                    </div>
                                                    <h6 class="mb-0 text-white">Подписка "Я первый"</h6>
                                                </div>
                                                <div class="card-body p-3">
                                                    <p class="text-sm">Получайте заявки от покупателей на 1 час раньше всех. Преимущество перед конкурентами!</p>
                                                    <ul class="list-group">
                                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Стоимость:</strong> $100 в месяц</li>
                                                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Текущий статус:</strong> 
                                                            @if(auth()->user()->has_premium_subscription)
                                                                <span class="badge bg-gradient-success">Активна</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Не активна</span>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                    @if(!auth()->user()->has_premium_subscription)
                                                        <form action="{{ route('paid-services.premium-subscription') }}" method="POST" class="mt-3">
                                                            @csrf
                                                            <button type="submit" class="btn btn-another-primary mb-0">Активировать подписку</button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-another-primary mb-0 mt-3" disabled>Подписка активна</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Вкладка безопасности -->
                        <div class="tab-pane fade" id="v-pills-security" role="tabpanel">
                            <div class="card">
                                <div class="card-header p-3 pt-2">
                                    <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
                                        <i class="material-symbols-rounded opacity-10">lock</i>
                                    </div>
                                    <h6 class="mb-0">Безопасность</h6>
                                </div>
                                <div class="card-body pt-0">
                                    <form action="{{ route('profile.updatePassword') }}" method="POST">
                                        @csrf
                                        <div class="input-group input-group-static mb-4">
                                            <label>Текущий пароль</label>
                                            <input type="password" class="form-control" name="current_password" required>
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label>Новый пароль</label>
                                            <input type="password" class="form-control" name="new_password" required>
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label>Подтвердите новый пароль</label>
                                            <input type="password" class="form-control" name="new_password_confirmation" required>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Изменить пароль</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection