@extends('layouts.app')

@section('content')
    <header>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 position-relative z-index-1">
                        <div class="d-flex align-items-center">
                            <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.5714 7.07812C18.5714 7.24182 18.4747 7.42039 18.2813 7.61384L14.2299 11.5647L15.1897 17.1451C15.1972 17.1972 15.2009 17.2716 15.2009 17.3683C15.2009 17.5246 15.16 17.6548 15.0781 17.7589C15.0037 17.8705 14.8921 17.9263 14.7433 17.9263C14.6019 17.9263 14.4531 17.8817 14.2969 17.7924L9.28571 15.1585L4.27455 17.7924C4.11086 17.8817 3.96205 17.9263 3.82813 17.9263C3.67188 17.9263 3.55283 17.8705 3.47098 17.7589C3.39658 17.6548 3.35938 17.5246 3.35938 17.3683C3.35938 17.3237 3.36682 17.2493 3.3817 17.1451L4.34152 11.5647L0.279018 7.61384C0.093006 7.41295 0 7.23437 0 7.07812C0 6.80283 0.208333 6.6317 0.625 6.56473L6.22768 5.75L8.73884 0.671874C8.88021 0.366815 9.0625 0.214285 9.28571 0.214285C9.50893 0.214285 9.69122 0.366815 9.83259 0.671874L12.3438 5.75L17.9464 6.56473C18.3631 6.6317 18.5714 6.80283 18.5714 7.07812Z" fill="#f69459" />
                            </svg>
                            <p  class="secondary-color text-primary font-weight-bold mb-0 ms-2">
                                12,000+ Проверенных Покупателей
                            </p>
                        </div>
                        <h1 class="main-color">Textil Server</h1>
                        <p class="text-lg mt-3">
                            Откройте новую жизнь в мире оптового маркетплейса. Работайте с дома через безопасные сделки и используйте функции ИИ для улучшения ваших продаж
                        </p>
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar-group">
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Martin Doe" data-bs-original-title="Martin Doe">
                                    <img alt="Image placeholder" src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/bruce-mars.jpg">
                                </a>
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Romina Hadid" data-bs-original-title="Romina Hadid">
                                    <img alt="Image placeholder" src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/team-5.jpg">
                                </a>
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Alexa Tompson" data-bs-original-title="Alexa Tompson">
                                    <img alt="Image placeholder" src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/team-3.jpg">
                                </a>
                            </div>
                            <p class="mb-0 ms-2"> 3,500+  Продавцов</p>
                        </div>
                        <div class="d-block d-md-flex" style="gap: 10px;">

                            <a href="{{route('login.page')}}" target="_blank" class="btn w-100 w-md-auto btn-primary main-btn-active">Продавец</a>
                            <a href="{{route('login.page')}}" target="_blank" class="btn w-100 w-md-auto btn-outline-primary main-btn">Покупатель</a>

                        </div>
                    </div>
                   
                    <img class="position-absolute top-0 mt-n7 me-n12 end-0 w-70 z-index-3" src="/assets/img/perspective.png" alt="header-image">
                </div>
            </div>
        </div>
    </header>

<div class="card card-body mx-3 mx-md-4 mt-n6 z-index-1 position-relative">


    <section class="my-5 py-5" id="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="position-sticky pb-lg-5 pb-3 mt-lg-0 ps-2">
                        <h5 class="text-primary fw-bold text-uppercase primary-text-color">Почему выбирают TextilServer</h5>
                        <h3 class="mb-4">Ваш идеальный инструмент для текстильного бизнеса</h3>
                        <p class="text-secondary pe-3">
                            Единственная международная площадка с полным циклом услуг – от поиска поставщиков до организации логистики. 🚀 Без границ и посредников – прямые сделки между производителями и покупателями со всего мира.
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <!-- 1. Быстрые заявки -->
                        <div class="col-md-6">
                            <div class="card feature-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="bi bi-lightning-charge-fill text-primary mb-3" style="font-size: 2.5rem;"></i>
                                    <h5>Бесплатный сервис</h5>
                                    <p class="text-muted">Основные функции сервиса абсолютно бесплатные</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 2. Каталог поставщиков -->
                        <div class="col-md-6">
                            <div class="card feature-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="bi bi-building-check text-primary mb-3" style="font-size: 2.5rem;"></i>
                                    <h5>База 3,500+ производителей</h5>
                                    <p class="text-muted">Проверенные продавцы с полными данными и историей сделок</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 3. ИИ-ассистент -->
                        <div class="col-md-6">
                            <div class="card feature-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="bi bi-robot text-primary mb-3" style="font-size: 2.5rem;"></i>
                                    <h5>AI-ассистент</h5>
                                    <p class="text-muted">Автоматическая генерация продающих текстов и объявлений</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 4. Кросспостинг -->
                        <div class="col-md-6">
                            <div class="card feature-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="bi bi-arrow-left-right text-primary mb-3" style="font-size: 2.5rem;"></i>
                                    <h5>Автопостинг</h5>
                                    <p class="text-muted">Ваши объявления были собраны с различных ресурсов группой аналитиков и уже размещены на платформе!</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 5. Поддержка 24/7 -->
                        <div class="col-md-6">
                            <div class="card feature-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="bi bi-headset text-primary mb-3" style="font-size: 2.5rem;"></i>
                                    <h5>Поддержка 24/7</h5>
                                    <p class="text-muted">Персональный менеджер и юридическое сопровождение сделок</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 6. Аналитика рынка -->
                        <div class="col-md-6">
                            <div class="card feature-card h-100">
                                <div class="card-body text-center p-4">
                                    <i class="bi bi-graph-up-arrow text-primary mb-3" style="font-size: 2.5rem;"></i>
                                    <h5>Рыночная аналитика</h5>
                                    <p class="text-muted">Актуальные цены и спрос по всем категориям текстиля</p>
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
    </style>

       <!-- Секция отзывов клиентов -->
<section id="testimonials" class="py-8 bg-gray-100 secondary-background" style="border-radius: 8px;">
    <div class="container">
        <div class="row mb-6 text-center">
            <div class="col-lg-8 mx-auto">
                <h5 class="text-primary fw-bold text-uppercase primary-text-color">Нам доверяют</h5>
                <h2 class="mb-3 main-color">3,500+ продавцов и 12,000+ покупателей <br>уже с нами</h2>
                <p class="lead secondary-color">Крупнейший маркетплейс текстиля в СНГ с общим оборотом $28M+ в 2024 году</p>
            </div>
        </div>

        <div class="row align-items-center">
            <!-- Блок с отзывами -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-5">
                        <div id="textileCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Отзыв 1 -->
                                <div class="carousel-item active">
                                    <div class="d-flex mb-4">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                        <p>"Через 3 дня после регистрации получили первый заказ на 2,000 полотенец. 
                                        Через месяц подписали контракт на регулярные поставки. Платформа реально работает!"</p>
                                    <div class="d-flex align-items-center">
                                        <img src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/bruce-mars.jpg" alt="Алишер Камилов" class="avatar rounded-circle me-3 shadow">
                                        <div>
                                            <h6 class="mb-0">Алишер Камилов</h6>
                                            <small class="text-muted">Директор "Bahar Textile"</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Отзыв 2 -->
                                <div class="carousel-item">
                                    <div class="d-flex mb-4">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                        <p>"Нашли поставщика постельного белья с идеальным соотношением цена/качество. 
                                        Экономия 23% по сравнению с предыдущим поставщиком. Оформление заказа заняло 15 минут!"</p>
                                    <div class="d-flex align-items-center">
                                        <img src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/team-5.jpg" alt="Елена Воронина" class="avatar rounded-circle me-3 shadow">
                                        <div>
                                            <h6 class="mb-0">Елена Воронина</h6>
                                            <small class="text-muted">Владелец сети "Дом Текстиля"</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-controls mt-4">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Блок с цифрами -->
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <h2 class="primary-text-color mb-0">28M+</h2>
                                <p class="mb-0">Общий оборот сделок</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <h2 class="primary-text-color mb-0">3,500+</h2>
                                <p class="mb-0">Проверенных продавцов</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <h2 class="primary-text-color mb-0">12K+</h2>
                                <p class="mb-0">Активных покупателей</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <h2 class="primary-text-color mb-0">24/7</h2>
                                <p class="mb-0">Поддержка на 4 языках</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Секция последних объявлений -->
<section id="latest-ads" class="py-2 bg-light"  style="margin-top: 20px; border-radius: 8px">
    <div class="container">
        @include('components.banners')

        <div class="row py-4 mb-6 text-center">
            <div class="col-lg-8 mx-auto">
                <h5 class="text-primary fw-bold text-uppercase primary-text-color">Свежие предложения</h5>
                <h2 class="mb-3">Последние добавленные объявления</h2>
                <p class="lead secondary-text-color">Актуальные предложения от проверенных поставщиков</p>
            </div>
        </div>

        <div class="row">
            @php
                $latestResponses = \App\Models\Response::with('user', 'categories', 'countries', 'images')
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            @endphp

            @forelse($latestResponses->chunk(3) as $chunk)
                <div class="row mb-4">
                    @foreach($chunk as $response)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($response->images->first())
                                    <img src="{{ asset($response->images->first()->path) }}" class="card-img-top" 
                                         alt="{{ $response->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($response->title, 50) }}</h5>
                                    <p class="card-text text-muted small">{{ Str::limit($response->text, 80) }}</p>
                                    
                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                        @foreach($response->categories->take(2) as $category)
                                            <span class="badge bg-primary" style="font-size: 10px;">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt"></i> 
                                            @foreach($response->countries->take(1) as $country)
                                                {{ $country->name }}
                                            @endforeach
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-box"></i> {{ $response->count }} шт.
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-white border-0 pt-0">
                                    <a href="{{ route('responses.show', $response->id) }}" 
                                       class="btn btn-sm btn-primary w-100">
                                        Подробнее
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Пока нет объявлений
                    </div>
                </div>
            @endforelse
        </div>

        @if($latestResponses->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('responses.catalog') }}" class="btn btn-outline-primary">
                    Смотреть все объявления
                </a>
            </div>
        @endif
    </div>
</section>
<!-- Секция FAQ -->
<section id="faq" class="py-8">
    <div class="container">
        <div class="row mb-6 text-center">
            <div class="col-lg-8 mx-auto">
                <h5 class="text-primary fw-bold text-uppercase primary-text-color">Вопросы и ответы</h5>
                <h2 class="mb-3">Частые вопросы о работе платформы</h2>
                <p class="lead secondary-text-color">Все, что вам нужно знать о текстильном маркетплейсе</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="textileAccordion">
                    <!-- Вопрос 1 -->
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded ">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button py-3 fw-bold secondary-background main-color" style="padding: 10px; border-top-left-radius: 8px;border-top-right-radius: 8px;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Как быстро я получу предложения после создания заявки?
                                <i class="bi bi-chevron-down ms-auto text-primary"></i>
                            </button>
                        </h3>
                        <div id="collapseOne" class="accordion-collapse collapse show" style="padding: 10px; " aria-labelledby="headingOne" data-bs-parent="#textileAccordion">
                            <div class="accordion-body">
                                В 85% случаев первые предложения поступают в течение 2 часов. Наш алгоритм мгновенно уведомляет подходящих поставщиков о вашем запросе. Для срочных заказов рекомендуем использовать функцию "Быстрый поиск".
                            </div>
                        </div>
                    </div>

                    <!-- Вопрос 2 -->
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded">
                        <h3 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed py-3 fw-bold secondary-background main-color" style="padding: 10px; border-top-left-radius: 8px;border-top-right-radius: 8px;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Есть ли комиссия за сделки на платформе?
                                <i class="bi bi-chevron-down ms-auto text-primary"></i>
                            </button>
                        </h3>
                        <div id="collapseTwo" class="accordion-collapse collapse" style="padding: 10px; " aria-labelledby="headingTwo" data-bs-parent="#textileAccordion">
                            <div class="accordion-body">
                                Нет, платформа полностью бесплатна для покупателей и поставщиков. Мы не берем комиссию за сделки и не накручиваем цены. Все платежи происходят напрямую между участниками сделки.
                            </div>
                        </div>
                    </div>

                    <!-- Вопрос 3 -->
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded">
                        <h3 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed py-3 fw-bold secondary-background main-color" style="padding: 10px; border-top-left-radius: 8px;border-top-right-radius: 8px;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Как проверить надежность поставщика?
                                <i class="bi bi-chevron-down ms-auto text-primary"></i>
                            </button>
                        </h3>
                        <div id="collapseThree" class="accordion-collapse collapse" style="padding: 10px; " aria-labelledby="headingThree" data-bs-parent="#textileAccordion">
                            <div class="accordion-body">
                                Каждый поставщик проходит верификацию:
                                <ul class="mt-2">
                                    <li>Проверка документов и сертификатов</li>
                                    <li>Отзывы от других покупателей</li>
                                    <li>История сделок на платформе</li>
                                    <li>Возможность запросить образцы</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Вопрос 4 -->
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded">
                        <h3 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed py-3 fw-bold secondary-background main-color" style="padding: 10px; border-top-left-radius: 8px;border-top-right-radius: 8px;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Как работает ИИ-ассистент для генерации текстов?
                                <i class="bi bi-chevron-down ms-auto text-primary"></i>
                            </button>
                        </h3>
                        <div id="collapseFour" class="accordion-collapse collapse" style="padding: 10px; "  aria-labelledby="headingFour" data-bs-parent="#textileAccordion">
                            <div class="accordion-body">
                                Наш ИИ анализирует:
                                <ul class="mt-2">
                                    <li>Технические характеристики вашей продукции</li>
                                    <li>Актуальные тренды в текстильной сфере</li>
                                    <li>Ключевые запросы покупателей</li>
                                </ul>
                                И создает продающие описания на русском, английском и узбекском языках за 30 секунд.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .avatar {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
    .accordion-button:not(.collapsed) {
        background-color: rgba(13, 110, 253, 0.05);
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
</style>

</div>
@endsection
