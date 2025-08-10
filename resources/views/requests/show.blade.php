@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('requests.catalog') }}">Каталог заявок</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($order->title, 30) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Левая колонка - информация о заявке -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="h2 mb-3">{{ $order->title }}</h1>
                    
                    <!-- Статус и мета-информация -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        
                        <span class="text-muted">
                            <i class="far fa-clock me-1"></i> {{ $order->created_at ? $order->created_at->diffForHumans() : 'Недавно' }}
                        </span>
                        
                        <span class="text-muted">
                            <i class="fas fa-eye me-1"></i> {{ $order->views ?? 0 }} просмотров
                        </span>
                    </div>
                    
                    <!-- Категории и страны -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @if($order->categories)
                        @foreach ($order->categories as $category)
                        <span class="badge bg-primary">{{ $category->name }}</span>                            
                        @endforeach
                        @endif

                        @if($order->countries)
                            @foreach ($order->countries as $country)
                        <span class="badge bg-secondary">{{ $country->name }}</span>
                                
                            @endforeach
                        @endif
                    </div>
                    
                    <!-- Основная информация -->
                    <div class="mb-4">
                        <h3 class="h4 mb-3">Описание заявки</h3>
                        <div class="text-muted" style="white-space: pre-line;">{{ $order->description }}</div>
                    </div>
                    
                    <!-- Дополнительные файлы (если есть) -->
                    @if($order->files && count($order->files) > 0)
                    <div class="mb-4">
                        <h3 class="h4 mb-3">Прикрепленные файлы</h3>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($order->files as $file)
                            <a href="{{ asset($file->path) }}" class="btn btn-outline-secondary" download>
                                <i class="fas fa-file-download me-2"></i> {{ $file->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Правая колонка - информация о заказчике и действия -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <!-- Информация о заказчике -->

                    <div class="text-center mb-4">
                        <img src="/storage/{{ ($order->customer->image_url) }}" 
                             class="rounded-circle mb-3" 
                             width="100" 
                             height="100" 
                             alt="{{ $order->user->name }}">
                        <h3 class="h5">{{ $order->user->name }}</h3>
                        
                        @if($order->user->brand)
                        <p class="text-muted">{{ $order->user->brand }}</p>
                        @endif
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            @if($order->user->rating > 0)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star"></i> {{ number_format($order->user->rating, 1) }}
                            </span>
                            @endif
                            
                            @if($order->user->year)
                            <span class="badge bg-info">
                                На рынке с {{ $order->user->year }} года
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Контактная информация -->
                    <div class="mb-4">
                        <h4 class="h5 mb-3">Контактная информация</h4>
                        <ul class="list-unstyled">
                            @if($order->user->phone)
                            <li class="mb-2">
                                <i class="fas fa-phone me-2"></i>
                                <a href="tel:{{ $order->user->phone }}" class="text-decoration-none">
                                    {{ $order->user->phone }}
                                </a>
                            </li>
                            @endif
                            
                            @if($order->user->telegram)
                            <li class="mb-2">
                                <i class="fab fa-telegram me-2"></i>
                                <a href="https://t.me/{{ $order->user->telegram }}" 
                                   target="_blank" class="text-decoration-none">
                                    {{ $order->user->telegram }}
                                </a>
                            </li>
                            @endif
                            
                            @if($order->user->whatsapp)
                            <li class="mb-2">
                                <i class="fab fa-whatsapp me-2"></i>
                                <a href="https://wa.me/{{ $order->user->whatsapp }}" 
                                   target="_blank" class="text-decoration-none">
                                    {{ $order->user->whatsapp }}
                                </a>
                            </li>
                            @endif
                            
                            @if($order->user->site)
                            <li class="mb-2">
                                <i class="fas fa-globe me-2"></i>
                                <a href="{{ $order->user->site }}" 
                                   target="_blank" class="text-decoration-none">
                                    {{ parse_url($order->user->site, PHP_URL_HOST) }}
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    
                    <!-- Кнопки действий -->
                    <div class="d-grid gap-2">
                        @if(auth()->id() != $order->user->id)
                        <button class="btn btn-primary btn-lg start-chat" 
                                data-seller-id="{{ $order->user->id }}" 
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
            @if($order->user->description || $order->user->business_type)
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h4 class="h5 mb-3">О компании</h4>
                    
                    @if($order->user->business_type)
                    <p><strong>Тип бизнеса:</strong> {{ $order->user->business_type }}</p>
                    @endif
                    
                    @if($order->user->count_employers !== '0')
                    <p><strong>Количество сотрудников:</strong> {{ $order->user->count_employers }}</p>
                    @endif
                    
                    @if($order->user->description)
                    <div class="text-muted" style="white-space: pre-line;">{{ $order->user->description }}</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
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
</script>

@endpush

<style>
    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
        z-index: 1020;
    }
    .card.bg-light {
        background-color: #f8f9fa!important;
    }
</style>
@endsection