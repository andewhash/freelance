@extends('layouts.app')

@section('content')
<div class="page-header min-vh-75" >
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="main-color mb-4">Тарифы и дополнительные услуги</h1>
                <p class="lead text-secondary">
                    Улучшите видимость вашей компании и увеличивайте продажи с нашими премиальными услугами
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card card-body mx-3 mx-md-4 mt-n6 z-index-1 position-relative">
    <section class="my-5 py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <!-- Проверка компании -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4" style="display: flex;flex-direction:column;justify-content:space-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-patch-check-fill text-primary me-2" style="font-size: 1.8rem;"></i>
                                        <h5 class="mb-0">Проверка компании</h5>
                                    </div>
                                    <p>Официальная проверка данных вашей компании нашими специалистами. После проверки ваш аккаунт получит статус "Проверенная компания".</p>
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Стоимость:</span>
                                            <span class="fw-bold">$50</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Текущий статус:</span>
                                        </div>
                                    </div>
                                    <a href="/profile" class="btn btn-sm btn-primary w-100 mt-3">Подробнее</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Баннерная реклама -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4" style="display: flex;flex-direction:column;justify-content:space-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-image-alt text-primary me-2" style="font-size: 1.8rem;"></i>
                                        <h5 class="mb-0">Баннерная реклама</h5>
                                    </div>
                                    <p>Размещение вашего баннера в верхней части сайта. Баннер будет показываться в выбранных категориях.</p>
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Стоимость:</span>
                                            <span class="fw-bold">$100 в месяц</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Доступные категории:</span>
                                            <span class="text-end">Все категории сайта</span>
                                        </div>
                                    </div>
                                    <a  href="/profile" class="btn btn-sm btn-primary w-100 mt-3">Заказать</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Реклама в поиске -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4" style="display: flex;flex-direction:column;justify-content:space-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-search text-primary me-2" style="font-size: 1.8rem;"></i>
                                        <h5 class="mb-0">Реклама в поиске</h5>
                                    </div>
                                    <p>Повышение позиции ваших товаров в результатах поиска. Чем выше ставка, тем выше позиция.</p>
                                    
                                    <div class="mt-3">
                                        <label class="form-label">Текущая ставка 100($)</label>
                                    </div>
                                    <a href="/profile" class="btn btn-sm btn-primary w-100 mt-3">Подробнее</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Реклама в каталоге -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4" style="display: flex;flex-direction:column;justify-content:space-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-grid-3x3-gap text-primary me-2" style="font-size: 1.8rem;"></i>
                                        <h5 class="mb-0">Реклама в каталоге</h5>
                                    </div>
                                    <p>Повышение позиции вашей компании в каталоге. Чем выше ставка, тем выше позиция.</p>

                                   
                                    <div class="mt-3">
                                        <label class="form-label">Текущая ставка 100($)</label>
                                    </div>
                                    <a href="/profile" class="btn btn-sm btn-primary w-100 mt-3">Подробнее</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Выездная проверка -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card feature-card h-100" >
                                <div class="card-body p-4" style="display: flex;flex-direction:column;justify-content:space-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-house-check text-primary me-2" style="font-size: 1.8rem;"></i>
                                        <h5 class="mb-0">Выездная проверка</h5>
                                    </div>
                                    <p>Наш специалист посетит вашу компанию для проведения профессиональной проверки и составления отчета.</p>
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Стоимость:</span>
                                            <span class="fw-bold">$100</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Длительность:</span>
                                            <span>2-3 рабочих дня</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary w-100 mt-3">Заказать проверку</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Подписка "Я первый" -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4" style="display: flex;flex-direction:column;justify-content:space-between">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-lightning-charge text-primary me-2" style="font-size: 1.8rem;"></i>
                                        <h5 class="mb-0">Подписка "Я первый"</h5>
                                    </div>
                                    <p>Получайте заявки от покупателей на 1 час раньше всех. Преимущество перед конкурентами!</p>
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Стоимость:</span>
                                            <span class="fw-bold">$100 в месяц</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary w-100 mt-3">Управлять подпиской</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        .feature-card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .main-color {
            color: #2c3e50;
        }
        .text-secondary {
            color: #6c757d !important;
        }
    </style>
</div>
@endsection