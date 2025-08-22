@extends('layouts.app')

@section('content')
<style>
.categories-filter-container {
    max-height: 400px;
    overflow-y: auto;
}

.category-level-0 {
    font-size: 1.1em;
    color: #333;
    border-bottom: 2px solid #f69459;
    padding-bottom: 5px;
}

.category-level-1 {
    font-size: 0.95em;
}

.category-level-2 {
    font-size: 0.9em;
}

.category-filter-checkbox:checked {
    background-color: #f69459;
    border-color: #f69459;
}

.form-check-label {
    cursor: pointer;
    user-select: none;
}

.form-check-input {
    cursor: pointer;
}

#show-more-categories,
#show-less-categories {
    border-radius: 20px;
    padding: 5px 15px;
    font-size: 0.8rem;
}
</style>
<div class="container mt-4 py-5">
    @include('components.banners')

    <!-- Поиск в шапке -->
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" action="{{ route('responses.catalog') }}" class="card shadow-sm">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control catalog-search-input" style="height: 36px;
                        box-shadow: 0 2px 2px 0 rgb(183 183 183 / 10%), 0 3px 1px -2px rgb(223 223 223 / 18%), 0 1px 5px 0 rgb(201 201 201 / 15%);
                        border-top-right-radius: 0px !important;
                        border-bottom-right-radius: 0px !important;" name="search" 
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
<!-- Фильтры слева -->
<div class="col-md-3">
    <form id="filter-form" method="GET" action="{{ route('responses.catalog') }}">
        <input type="hidden" name="search" value="{{ request('search') }}">
        
        <div class="card shadow-sm mb-4" style="border: none"> 
            <div class="card-header secondary-background text-white">
                <h5 class="mb-0 main-color">Фильтры</h5>
            </div>
            <div class="card-body">
                <!-- Поиск внутри фильтров -->
                <div class="mb-3">
                    <label class="form-label">Поиск в результатах</label>
                    <input type="text" class="form-control" name="search" 
                           placeholder="Поиск..." value="{{ request('search') }}"
                           onkeypress="if(event.keyCode == 13) { this.form.submit(); }">
                </div>
                
                <!-- Фильтр по категориям через иерархические чекбоксы -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Категории</label>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="reset-categories">
                            Сбросить
                        </button>
                    </div>
                    
                    <div class="categories-filter-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 15px;">
                        <div class="row">
                            @php
                                $displayedCategories = 0;
                                $maxInitialCategories = 5;
                            @endphp
                            
                            @foreach($allCategories as $category)
                                @if($displayedCategories < $maxInitialCategories)
                                    <div class="col-12 mb-3 category-block">
                                        <div class="category-level-0 fw-bold mb-2">
                                            {{ $category['name'] }}
                                        </div>
                                        
                                        @if(isset($category['children']))
                                            @foreach($category['children'] as $subCategory)
                                                <div class="category-level-1 ps-3 mb-2">
                                                    
                                                    @if(isset($subCategory['children']) && count($subCategory['children']) > 0)
                                                        <!-- Есть дочерние категории -->
                                                        <div class="fw-semibold text-muted">
                                                            {{ $subCategory['name'] }}
                                                        </div>
                                                        
                                                        @foreach($subCategory['children'] as $childCategory)
                                                            <div class="category-level-2 ps-4 mb-1">
                                                                <div class="form-check">
                                                                    <input class="form-check-input category-filter-checkbox" 
                                                                           type="checkbox" 
                                                                           name="categories[]" 
                                                                           value="{{ $childCategory['id'] }}"
                                                                           id="filter_category_{{ $childCategory['id'] }}"
                                                                           {{ in_array($childCategory['id'], (array)$categoryIds) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="filter_category_{{ $childCategory['id'] }}">
                                                                        {{ $childCategory['name'] }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <!-- Нет дочерних категорий -->
                                                        <div class="form-check">
                                                            <input class="form-check-input category-filter-checkbox" 
                                                                   type="checkbox" 
                                                                   name="categories[]" 
                                                                   value="{{ $subCategory['id'] }}"
                                                                   id="filter_category_{{ $subCategory['id'] }}"
                                                                   {{ in_array($subCategory['id'], (array)$categoryIds) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-semibold" for="filter_category_{{ $subCategory['id'] }}">
                                                                {{ $subCategory['name'] }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                    
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Если у корневой категории нет подкатегорий -->
                                            <div class="category-level-1 ps-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input category-filter-checkbox" 
                                                           type="checkbox" 
                                                           name="categories[]" 
                                                           value="{{ $category['id'] }}"
                                                           id="filter_category_{{ $category['id'] }}"
                                                           {{ in_array($category['id'], (array)$categoryIds) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="filter_category_{{ $category['id'] }}">
                                                        {{ $category['name'] }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @php $displayedCategories++; @endphp
                                @else
                                    <div class="col-12 mb-3 category-block" style="display: none;">
                                        <!-- Аналогичная структура для скрытых категорий -->
                                        <div class="category-level-0 fw-bold mb-2">
                                            {{ $category['name'] }}
                                        </div>
                                        
                                        @if(isset($category['children']))
                                            @foreach($category['children'] as $subCategory)
                                                <div class="category-level-1 ps-3 mb-2">
                                                    
                                                    @if(isset($subCategory['children']) && count($subCategory['children']) > 0)
                                                        <div class="fw-semibold text-muted">
                                                            {{ $subCategory['name'] }}
                                                        </div>
                                                        
                                                        @foreach($subCategory['children'] as $childCategory)
                                                            <div class="category-level-2 ps-4 mb-1">
                                                                <div class="form-check">
                                                                    <input class="form-check-input category-filter-checkbox" 
                                                                           type="checkbox" 
                                                                           name="categories[]" 
                                                                           value="{{ $childCategory['id'] }}"
                                                                           id="filter_category_{{ $childCategory['id'] }}"
                                                                           {{ in_array($childCategory['id'], (array)$categoryIds) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="filter_category_{{ $childCategory['id'] }}">
                                                                        {{ $childCategory['name'] }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="form-check">
                                                            <input class="form-check-input category-filter-checkbox" 
                                                                   type="checkbox" 
                                                                   name="categories[]" 
                                                                   value="{{ $subCategory['id'] }}"
                                                                   id="filter_category_{{ $subCategory['id'] }}"
                                                                   {{ in_array($subCategory['id'], (array)$categoryIds) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-semibold" for="filter_category_{{ $subCategory['id'] }}">
                                                                {{ $subCategory['name'] }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                    
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="category-level-1 ps-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input category-filter-checkbox" 
                                                           type="checkbox" 
                                                           name="categories[]" 
                                                           value="{{ $category['id'] }}"
                                                           id="filter_category_{{ $category['id'] }}"
                                                           {{ in_array($category['id'], (array)$categoryIds) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="filter_category_{{ $category['id'] }}">
                                                        {{ $category['name'] }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Кнопка "Показать еще" -->
                        @if(count($allCategories) > $maxInitialCategories)
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="show-more-categories">
                                <i class="fas fa-plus"></i> Показать еще
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="show-less-categories" style="display: none;">
                                <i class="fas fa-minus"></i> Свернуть
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Фильтр по странам -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Страны</label>
                        <button type="button" class="btn btn-sm btn-outline-secondary filter-reset" 
                                data-target="select[name='countries[]']">
                            Сбросить
                        </button>
                    </div>
                    <select class="form-control select2" name="countries[]" multiple>
                        @foreach($allCountries as $country)
                        <option value="{{ $country->id }}" 
                            {{ in_array($country->id, (array)$countryIds) ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Статус фильтров -->
                @if(!empty($categoryIds) || !empty($countryIds))
                <div class="alert alert-info py-2 mb-3">
                    <small>
                        <strong>Активные фильтры:</strong><br>
                        @foreach($categoryIds as $id)
                            @php 
                                $categoryName = '';
                                foreach ($allCategories as $cat) {
                                    if (isset($cat['children'])) {
                                        foreach ($cat['children'] as $subCat) {
                                            if (isset($subCat['children'])) {
                                                foreach ($subCat['children'] as $childCat) {
                                                    if ($childCat['id'] == $id) {
                                                        $categoryName = $childCat['name'];
                                                        break 3;
                                                    }
                                                }
                                            } else {
                                                if ($subCat['id'] == $id) {
                                                    $categoryName = $subCat['name'];
                                                    break 2;
                                                }
                                            }
                                        }
                                    } else {
                                        if ($cat['id'] == $id) {
                                            $categoryName = $cat['name'];
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @if($categoryName) • {{ $categoryName }}<br> @endif
                        @endforeach
                        @foreach($countryIds as $id)
                            @php $country = $allCountries->firstWhere('id', $id); @endphp
                            @if($country) • {{ $country->name }}<br> @endif
                        @endforeach
                    </small>
                </div>
                @endif
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Применить фильтры
                    </button>
                    <a href="{{ route('responses.catalog') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Сбросить все
                    </a>
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
                    <li class="breadcrumb-item active">Каталог предложений</li>
                </ol>
            </nav>
            
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
                        <div class="card-body" style="padding: 10px 1rem">
                            <h5 class="card-title" style="margin-bottom: 4px;">{{ $response->title }}</h5>
                            <p class="card-text" style="margin-bottom: 6px;">{{ Str::limit($response->text, 100) }}</p>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @foreach($response->countries->take(3) as $country)
                                <span class="badge bg-secondary" style="font-size:9px;">{{ $country->name }}</span>
                                @endforeach
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @foreach($response->categories->take(3) as $category)
                                <span class="badge bg-primary" style="font-size:9px;">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $response->count }} ₽</small>
                            </div>
                            <div>
                                <span class="small-text"  style="font-size: 12px;">{{ $response->user->name}} 
                                    ⭐ {{ number_format($response->user->average_rating, 1) }} ({{ $response->user->reviews_count }} отзывов)
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white" style="padding: 0 1rem">
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
                    <ul class="pagination ">
                        {{ $responses->withQueryString()->onEachSide(1)->links('vendor.pagination.custom') }}
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация Select2 для стран
    $('.select2').select2({
        theme: 'bootstrap-5',
        placeholder: 'Выберите страны',
        allowClear: true,
        width: '100%'
    });
    
    // Управление кнопками "Показать еще/Свернуть"
    const showMoreBtn = document.getElementById('show-more-categories');
    const showLessBtn = document.getElementById('show-less-categories');
    
    if (showMoreBtn) {
        showMoreBtn.addEventListener('click', function() {
            document.querySelectorAll('.category-block').forEach(block => {
                block.style.display = 'block';
            });
            showMoreBtn.style.display = 'none';
            showLessBtn.style.display = 'inline-block';
        });
    }
    
    if (showLessBtn) {
        showLessBtn.addEventListener('click', function() {
            const blocks = document.querySelectorAll('.category-block');
            for (let i = 5; i < blocks.length; i++) {
                blocks[i].style.display = 'none';
            }
            showMoreBtn.style.display = 'inline-block';
            showLessBtn.style.display = 'none';
        });
    }
    
    // Сброс категорий
    document.getElementById('reset-categories').addEventListener('click', function() {
        document.querySelectorAll('.category-filter-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedFiltersCount();
    });
    
    // Сброс стран
    document.querySelectorAll('.filter-reset').forEach(button => {
        button.addEventListener('click', function() {
            const target = this.dataset.target;
            $(target).val(null).trigger('change');
            updateSelectedFiltersCount();
        });
    });
    
    // Показ количества выбранных фильтров
    function updateSelectedFiltersCount() {
        const selectedCategories = Array.from(document.querySelectorAll('.category-filter-checkbox:checked'))
            .map(checkbox => checkbox.value);
        const selectedCountries = $('#filter-form select[name="countries[]"]').val() || [];
        const totalSelected = selectedCategories.length + selectedCountries.length;
        
        const filterTitle = document.querySelector('.card-header h5');
        if (totalSelected > 0) {
            filterTitle.innerHTML = `Фильтры <span class="badge bg-primary">${totalSelected}</span>`;
        } else {
            filterTitle.innerHTML = 'Фильтры';
        }
    }
    
    // Обновляем счетчик при изменении
    document.querySelectorAll('.category-filter-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedFiltersCount);
    });
    
    $('.select2').on('change', updateSelectedFiltersCount);
    
    // Инициализируем счетчик
    updateSelectedFiltersCount();
});
</script>
@endsection

