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