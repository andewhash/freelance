@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('responses.catalog') }}">Каталог объявлений</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($response->title, 30) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Левая колонка - информация о предложении -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm mb-4">
                <!-- Галерея изображений -->
                @if($response->images->count() > 0)
                <div class="product-gallery">
                    <div class="main-image mb-3">
                        <img src="{{ asset($response->images->first()->path) }}" 
                             class="img-fluid rounded w-100" 
                             alt="{{ $response->title }}"
                             style="max-height: 500px; object-fit: contain;">
                    </div>
                    @if($response->images->count() > 1)
                    <div class="thumbnail-container d-flex flex-wrap gap-2">
                        @foreach($response->images as $image)
                        <img src="{{ asset($image->path) }}" 
                             class="img-thumbnail" 
                             style="width: 80px; height: 80px; cursor: pointer; object-fit: cover;"
                             onclick="changeMainImage(this)" 
                             alt="{{ $response->title }}">
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

                <div class="card-body">
                    <h1 class="h2 mb-3">{{ $response->title }}</h1>
                    
                    <!-- Категории и страны -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($response->categories as $category)
                        <span class="badge bg-primary">{{ $category->name }}</span>
                        @endforeach
                        @foreach($response->countries as $country)
                        <span class="badge bg-secondary">{{ $country->name }}</span>
                        @endforeach
                    </div>
                    
                    <!-- Основная информация -->
                    <div class="mb-4">
                        <h3 class="h4 mb-3">Описание</h3>
                        <p class="text-muted" style="white-space: pre-line;">{{ $response->text }}</p>
                    </div>
                    
                    <!-- Детали предложения -->
                    <div class="mb-4">
                        <h3 class="h4 mb-3">Детали предложения</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Количество:</strong> {{ $response->count }} шт.</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Дата публикации:</strong> {{ $response->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Дополнительная информация (если есть) -->
            @if($response->additional_info)
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="h4 mb-3">Дополнительная информация</h3>
                    <div class="text-muted" style="white-space: pre-line;">{{ $response->additional_info }}</div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Правая колонка - информация о пользователе и действия -->
        <div class="col-lg-4 " >
            <div class="card shadow-sm ">
                <div class="card-body">
                    <!-- Информация о пользователе -->
                    <div class="text-center mb-4">
                        <img src="/storage/{{ $response->user->image_url }}" 
                             class="rounded-circle mb-3" 
                             width="100" 
                             height="100" 
                             alt="{{ $response->user->name }}">
                        <h3 class="h5">{{ $response->user->name }}</h3>
                        
                        @if($response->user->brand)
                        <p class="text-muted">{{ $response->user->brand }}</p>
                        @endif
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            @if($response->user->rating > 0)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star"></i> {{ number_format($response->user->rating, 1) }}
                            </span>
                            @endif
                            
                            @if($response->user->year)
                            <span class="badge bg-info">
                                На рынке с {{ $response->user->year }} года
                            </span>
                            @endif

                        </div>
                        <div class="d-flex justify-content-center gap-2 mb-3">

                            @if($response->user->is_verified_company)
                            <span class="badge bg-success">
                                Подтвержденная компания
                            </span>
                            @else
                            <span class="badge bg-danger">
                                Не подтвержденная компания
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Контактная информация -->
                    <div class="mb-4">
                        <h4 class="h5 mb-3">Контактная информация</h4>
                        <ul class="list-unstyled">
                            @if($response->user->phone)
                            <li class="mb-2">
                                <i class="fas fa-phone me-2"></i>
                                <a href="tel:{{ $response->user->phone }}" class="text-decoration-none">
                                    {{ $response->user->phone }}
                                </a>
                            </li>
                            @endif
                            
                            @if($response->user->telegram)
                            <li class="mb-2">
                                <i class="fab fa-telegram me-2"></i>
                                <a href="https://t.me/{{ $response->user->telegram }}" 
                                   target="_blank" class="text-decoration-none">
                                    {{ $response->user->telegram }}
                                </a>
                            </li>
                            @endif
                            
                            @if($response->user->whatsapp)
                            <li class="mb-2">
                                <i class="fab fa-whatsapp me-2"></i>
                                <a href="https://wa.me/{{ $response->user->whatsapp }}" 
                                   target="_blank" class="text-decoration-none">
                                    {{ $response->user->whatsapp }}
                                </a>
                            </li>
                            @endif
                            
                            @if($response->user->site)
                            <li class="mb-2">
                                <i class="fas fa-globe me-2"></i>
                                <a href="{{ $response->user->site }}" 
                                   target="_blank" class="text-decoration-none">
                                    {{ parse_url($response->user->site, PHP_URL_HOST) }}
                                </a>
                            </li>
                            @endif
                    
                            @if($response->user->address)
                            <li class="mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                {{$response->user->country}} {{$response->user->region}} {{$response->user->city}} {{ $response->user->address }}
                            </li>
                            @endif
                        </ul>
                    </div>
                    
                    <!-- Кнопки действий -->
                    <div class="d-grid gap-2">

                        @if(auth()->id() != $response->user->id)
                        <button class="btn btn-primary btn-lg start-chat" 
                                data-seller-id="{{ $response->user->id }}" 
                                data-customer-id="{{ auth()->id() }}">
                            <i class="fas fa-envelope me-2"></i> Написать сообщение (ДЕМО)
                        </button>
                        @endif

                        {{-- <button class="btn btn-outline-secondary">
                            <i class="fas fa-heart me-2"></i> Добавить в избранное
                        </button> --}}
                    </div>
                </div>
            </div>
            
            <!-- Дополнительная информация о компании -->
            @if($response->user->description || $response->user->business_type)
            <div class="card   shadow-sm mt-4">
                <div class="card-body">
                    <h4 class="h5 mb-3">О компании</h4>
                    @if($response->user->business_type)
                    <p><strong>Тип бизнеса:</strong> 
                    @switch($response->user->business_type)
                        @case('manufacturer')
                            Производитель
                            @break
                        @case('distributor')
                            Дистрибьютор
                            @break
                        @case('wholesaler')
                            Оптовик
                            @break
                        @default
                            Неизвестный тип
                    @endswitch
                    </p>
                @endif
                    
                    @if($response->user->count_employers !== '0')
                    <p><strong>Количество сотрудников:</strong> {{ $response->user->count_employers }}</p>
                    @endif
                    
                    @if($response->user->description)
                    <div class="text-muted" style="white-space: pre-line;">{{ $response->user->description }}</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <!-- Скрипт для галереи изображений -->
<script>
    $('.start-chat').click(function() {
        $(this).attr({'disabled': true})
        const sellerId = $(this).data('seller-id');
        const customerId = $(this).data('customer-id');
        
        $.post('{{ route("profile.chats.store") }}', {
            seller_id: sellerId,
            customer_id: customerId,
            _token: '{{ csrf_token() }}'
        }, function(response) {
            window.location.href = '{{ route("profile.chats", "") }}/' + response.chat_id;
        });
    });
    function changeMainImage(element) {
        const mainImage = document.querySelector('.main-image img');
        mainImage.src = element.src;
    }
    
    function sendMessage() {
        // Здесь будет логика отправки сообщения
        alert('Сообщение отправлено!');
        const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
        modal.hide();
    }
</script>

@endpush

<style>
    .product-gallery .img-thumbnail:hover {
        border-color: #0d6efd;
    }
    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
        z-index: 1020;
    }
</style>
@endsection