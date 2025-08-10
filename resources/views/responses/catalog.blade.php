@extends('layouts.app')

@section('content')
<div class="container mt-8 py-5">
    <!-- Поиск в шапке -->
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" action="{{ route('responses.catalog') }}" class="card shadow-sm">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Поиск по объявлениям..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Найти
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Фильтры слева -->
        <div class="col-md-3">
            <form id="filter-form" method="GET" action="{{ route('responses.catalog') }}">
                <div class="card shadow-sm mb-4" style="border: none"> 
                    <div class="card-header secondary-background text-white">
                        <h5 class="mb-0 main-color">Фильтры</h5>
                    </div>
                    <div class="card-body">
                        <!-- Фильтр по категориям -->
                        <div class="mb-4">
                            <label class="form-label">Категории</label>
                            <select class="form-control select2" name="categories[]" multiple>
                                @foreach($allCategories as $category)
                                <option value="{{ $category->id }}" 
                                    @if(in_array($category->id, $categoryIds)) selected @endif>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Фильтр по странам -->
                        <div class="mb-4">
                            <label class="form-label">Страны</label>
                            <select class="form-control select2" name="countries[]" multiple>
                                @foreach($allCountries as $country)
                                <option value="{{ $country->id }}" 
                                    @if(in_array($country->id, $countryIds)) selected @endif>
                                    {{ $country->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Применить</button>
                            <a href="{{ route('responses.catalog') }}" class="btn btn-outline-secondary">Сбросить</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Основной контент -->
        <div class="col-md-9">
            <!-- Хлебные крошки -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-white p-3 shadow-sm rounded">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Каталог объявлений</li>
                </ol>
            </nav>
            
            <!-- Результаты поиска -->
            @if(request('search'))
            <div class="alert alert-info mb-4">
                Результаты поиска по запросу: "{{ request('search') }}"
            </div>
            @endif
            
            <!-- Список объявлений -->
            @if($responses->count() > 0)
            <div class="row">
                @foreach($responses as $response)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($response->images->first())
                        <img src="{{ asset($response->images->first()->path) }}" class="card-img-top" 
                             alt="{{ $response->title }}" style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $response->title }}</h5>
                            <p class="card-text">{{ Str::limit($response->text, 100) }}</p>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @foreach($response->countries as $country)
                                <span class="badge bg-secondary" style="font-size:12px;">{{ $country->name }}</span>
                                @endforeach
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @foreach($response->categories as $category)
                                <span class="badge bg-primary" style="font-size:12px;">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $response->count }} шт.</small>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('responses.show', $response->id) }}" class="btn btn-sm btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-warning">
                Объявления не найдены. Попробуйте изменить параметры поиска.
            </div>
            @endif
            
            <!-- Пагинация -->
            @if($responses->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination shadow-sm">
                        {{ $responses->withQueryString()->onEachSide(1)->links('vendor.pagination.custom') }}
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

