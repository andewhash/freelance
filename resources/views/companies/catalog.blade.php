@extends('layouts.app')

@section('content')
<div class="container mt-8 py-5">
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" action="{{ route('companies.catalog') }}" class="card shadow-sm">
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
            <div class="card shadow-sm mb-4" style="border: none">
                <div class="card-header secondary-background text-white">
                    <h5 class="mb-0 main-color" >Фильтры</h5>
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
                    <button type="submit" class="btn btn-primary main-btn-active btn-sm">Применить</button>
                    <a href="{{ route('companies.catalog') }}" class="btn btn-outline-secondary btn-sm">Сбросить</a>
                </div>
            </div>
        </div>
        
        <!-- Основной контент -->
        <div class="col-md-9">
            <!-- Хлебные крошки -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white p-3 shadow-sm rounded">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    @foreach($breadcrumbs as $crumb)
                        @if(!$loop->last)
                        <li class="breadcrumb-item"><a href="{{ route('companies.catalog', ['category' => $crumb['id']]) }}">{{ $crumb['name'] }}</a></li>
                        @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $crumb['name'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
            
            <!-- Список компаний -->
            <div class="row">
                @foreach($companies as $company)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $company->image_url }}" class="card-img-top" alt="{{ $company->name }}" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $company->name }}</h5>
                            <p class="card-text text-muted">{{ $company->country }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="badge bg-primary">{{ $company->business_type }}</div>
                                <small class="text-muted">{{ $company->year }} год</small>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('companies.show', $company->id) }}" class="btn btn-sm btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Пагинация -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination shadow-sm">
                        {{ $companies->onEachSide(1)->links('vendor.pagination.custom') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection