@extends('layouts.app')

@section('content')
<div class="container py-5 mt-8">
    <div class="row">
        <div class="col-md-4">
            <!-- Блок с основной информацией -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Профиль компании</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $user->image_url }}" alt="{{ $user->name }}" class="rounded-circle mb-3" width="150" height="150">
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->brand }}</p>
                    
                    <div class="d-flex justify-content-center mb-3">
                        <span class="badge bg-{{ $user->exported ? 'success' : 'secondary' }}">
                            {{ $user->exported ? 'Экспортер' : 'Не экспортер' }}
                        </span>
                    </div>
                    
                    <div class="rating mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $user->rating ? 'text-warning' : 'text-secondary' }}"></i>
                        @endfor
                        <span>({{ $user->rating_votes ?? 0 }})</span>
                    </div>
                </div>
            </div>
            
            <!-- Контактная информация -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Контакты</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </li>
                        @if($user->phone)
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
                        </li>
                        @endif
                        @if($user->site)
                        <li class="mb-2">
                            <i class="fas fa-globe me-2"></i>
                            <a href="{{ $user->site }}" target="_blank">{{ $user->site }}</a>
                        </li>
                        @endif
                        @if($user->telegram)
                        <li class="mb-2">
                            <i class="fab fa-telegram me-2"></i>
                            <a href="https://t.me/{{ $user->telegram }}" target="_blank">{{ $user->telegram }}</a>
                        </li>
                        @endif
                        @if($user->whatsapp)
                        <li class="mb-2">
                            <i class="fab fa-whatsapp me-2"></i>
                            <a href="https://wa.me/{{ $user->whatsapp }}" target="_blank">{{ $user->whatsapp }}</a>
                        </li>
                        @endif
                        @if($user->address)
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $user->address }}
                        </li>
                        @endif
                        @if($user->country)
                        <li class="mb-2">
                            <i class="fas fa-flag me-2"></i>
                            {{ $user->country }}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Основная информация -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">О компании</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Тип бизнеса:</strong> {{ $user->business_type ?? 'Не указано' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Год основания:</strong> {{ $user->year ?? 'Не указан' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Количество сотрудников:</strong> {{ $user->count_employers }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Годовой оборот:</strong> {{ $user->mark ?? 'Не указан' }}</p>
                        </div>
                    </div>
                    
                    <h5 class="mt-4">Описание</h5>
                    <p>{{ $user->description ?? 'Описание компании отсутствует' }}</p>
                </div>
            </div>
            
            <!-- Категории компании -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Категории деятельности</h5>
                </div>
                <div class="card-body">
                    @if($user->categories->count() > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($user->categories as $category)
                                <span class="badge bg-secondary">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p>Категории не указаны</p>
                    @endif
                </div>
            </div>
            
            <!-- Дополнительные блоки -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Баланс</h5>
                        </div>
                        <div class="card-body text-center">
                            <h3>{{ number_format($user->balance, 2) }} USD</h3>
                            @if(auth()->user() && auth()->user()->id == $user->id)
                                <a href="{{ route('balance.replenish') }}" class="btn btn-sm btn-primary mt-2">Пополнить</a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Статус</h5>
                        </div>
                        <div class="card-body text-center">
                            <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'warning' }}">
                                {{ $user->status == 'active' ? 'Активен' : 'На модерации' }}
                            </span>
                            <p class="mt-2 small">Зарегистрирован: {{ $user->created_at ? $user->created_at->format('d.m.Y') : $user->updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Для администратора -->
            @can('admin')
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Администратор</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-danger">Редактировать</a>
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection