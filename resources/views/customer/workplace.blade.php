@extends('layouts.app')

@section('content')
<div class="main-content position-relative min-height-vh-100 h-100">
    <div class="container">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('/img/background.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-body mx-2 mx-md-4 mt-n6">
                    <!-- Блок для отображения сообщений об ошибках и успехах -->
                    @if($errors->any())
                        <div style="margin: 0 10px;" class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
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
                        <div style="margin: 0 10px;" class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>Ваши запросы</h6>
                            <button class="btn main-btn-active" data-bs-toggle="modal" data-bs-target="#createRequestModal">
                               Создать запрос
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0" style="min-height: 200px">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Название</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Описание</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Категории</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Страны</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Изображения</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($requests))
                                        @foreach($requests as $request)
                                            <tr>
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $request->id }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $request->title }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">{{ Str::limit($request->description, 50) }}</p>
                                                </td>
                                                <td>
                                                    @foreach($request->categories as $category)
                                                        <span class="badge badge-sm bg-primary">{{ $category->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($request->countries as $country)
                                                        <span class="badge badge-sm bg-secondary">{{ $country->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($request->images as $image)
                                                        <img src="{{ $image->path }}" width="50" class="me-2 border-radius-lg">
                                                    @endforeach
                                                </td>
                                                <td class="align-middle">
                                                    <button class="btn btn-sm btn-warning mb-0" data-bs-toggle="modal" data-bs-target="#editRequestModal" 
                                                        data-id="{{ $request->id }}" 
                                                        data-title="{{ $request->title }}" 
                                                        data-description="{{ $request->description }}"
                                                        data-categories="{{ $request->categories->pluck('id')->toJson() }}"
                                                        data-countries="{{ $request->countries->pluck('id')->toJson() }}">
                                                        Редактировать
                                                    </button>

                                                    <form action="{{ route('customer.requests.destroy', $request->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger mb-0" onclick="return confirm('Вы уверены?')">
                                                            Удалить
                                                        </button>
                                                    </form>

                                                    @if($request->responses()->where('status', \App\Enum\Response\ResponseStatusEnum::ACTIVE)->count() > 0)
                                                        <button class="btn btn-sm btn-info mb-0" data-bs-toggle="modal" data-bs-target="#responsesModal" data-id="{{ $request->id }}">
                                                            Отклики ({{ $request->responses()->where('status', \App\Enum\Response\ResponseStatusEnum::ACTIVE)->count() }})
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="7">
                                            <div class="alert alert-warning">
                                                У вас пока нет запросов
                                            </div>
                                        </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal для создания запроса -->
<div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('customer.requests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createRequestModalLabel">Создать запрос</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4 @error('title') is-invalid @enderror">
                                <label for="title">Название *</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="input-group input-group-static mb-4 @error('description') is-invalid @enderror">
                                <label for="description">Описание *</label>
                                <textarea class="form-control" name="description" id="description-input" rows="3" required>{{ old('description') }}</textarea>
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="button" id="generate-text-btn" class="btn btn-sm main-btn-active" disabled>
                                        <span id="generate-text-label">Спросить ИИ</span>
                                        <span id="generate-text-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Блок стран -->
                            <div style="display: flex; flex-direction: column;" class="input-group input-group-static mb-4 @error('countries') is-invalid @enderror">
                                <label for="countries">Страны *</label>
                                <select class="form-control select2" name="countries[]" id="countries" multiple required>
                                    @foreach(\App\Models\Country::all() as $country)
                                        <option value="{{ $country->id }}" @if(in_array($country->id, old('countries', []))) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('countries')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Блок категорий с чекбоксами -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="input-group input-group-static mb-3 @error('categories') is-invalid @enderror">
                                <label>Категории *</label>
                                <div class="categories-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 15px;">
                                    <div class="row">
                                        @php
                                            $categories = \App\Models\Category::getHierarchicalForCheckboxes();
                                        @endphp
                                        
                                        @foreach($categories as $category)
                                            <div class="col-md-4 mb-3">
                                                <div class="category-level-0 fw-bold mb-2">
                                                    {{ $category['name'] }}
                                                </div>
                                                
                                                @if(isset($category['children']))
                                                    @foreach($category['children'] as $subCategory)
                                                        <div class="category-level-1 ps-3 mb-2">
                                                            
                                                            @if(isset($subCategory['children']) && count($subCategory['children']) > 0)
                                                                <!-- Есть дочерние категории - показываем как заголовок -->
                                                                <div class="fw-semibold text-muted">
                                                                    {{ $subCategory['name'] }}
                                                                </div>
                                                                
                                                                @foreach($subCategory['children'] as $childCategory)
                                                                    <div class="category-level-2 ps-4 mb-1">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input category-checkbox" 
                                                                                   type="checkbox" 
                                                                                   name="categories[]" 
                                                                                   value="{{ $childCategory['id'] }}"
                                                                                   id="category_{{ $childCategory['id'] }}"
                                                                                   @if(in_array($childCategory['id'], old('categories', []))) checked @endif>
                                                                            <label class="form-check-label" for="category_{{ $childCategory['id'] }}">
                                                                                {{ $childCategory['name'] }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <!-- Нет дочерних категорий - показываем как чекбокс -->
                                                                <div class="form-check">
                                                                    <input class="form-check-input category-checkbox" 
                                                                           type="checkbox" 
                                                                           name="categories[]" 
                                                                           value="{{ $subCategory['id'] }}"
                                                                           id="category_{{ $subCategory['id'] }}"
                                                                           @if(in_array($subCategory['id'], old('categories', []))) checked @endif>
                                                                    <label class="form-check-label fw-semibold" for="category_{{ $subCategory['id'] }}">
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
                                                            <input class="form-check-input category-checkbox" 
                                                                   type="checkbox" 
                                                                   name="categories[]" 
                                                                   value="{{ $category['id'] }}"
                                                                   id="category_{{ $category['id'] }}"
                                                                   @if(in_array($category['id'], old('categories', []))) checked @endif>
                                                            <label class="form-check-label" for="category_{{ $category['id'] }}">
                                                                {{ $category['name'] }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('categories')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group input-group-static mb-4 @error('images') is-invalid @enderror">
                                <label for="images">Изображения</label>
                                <input type="file" class="form-control" name="images[]" id="images" multiple>
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-another-primary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" id="submit-btn-create" class="btn main-btn-active">Создать</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Modal для редактирования запроса -->
<div class="modal fade" id="editRequestModal" tabindex="-1" aria-labelledby="editRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('customer.requests.update', 'request_id') }}" method="POST" id="editRequestForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editRequestModalLabel">Редактировать запрос</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="editTitle">Название *</label>
                                <input type="text" class="form-control" name="title" id="editTitle" required>
                            </div>
                            
                            <div class="input-group input-group-static mb-4">
                                <label for="editDescription">Описание *</label>
                                <textarea class="form-control" name="description" id="editDescription" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Блок стран -->
                            <div style="display: flex; flex-direction: column;" class="input-group input-group-static mb-4">
                                <label for="editCountries">Страны *</label>
                                <select class="form-control select2" name="countries[]" id="editCountries" multiple required>
                                    @foreach(\App\Models\Country::all() as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Блок категорий с чекбоксами -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="input-group input-group-static mb-3">
                                <label>Категории *</label>
                                <div class="categories-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 15px;">
                                    <div class="row" id="editCategoriesContainer">
                                        @php
                                            $categories = \App\Models\Category::getHierarchicalForCheckboxes();
                                        @endphp
                                        
                                        @foreach($categories as $category)
                                            <div class="col-md-4 mb-3">
                                                <div class="category-level-0 fw-bold mb-2">
                                                    {{ $category['name'] }}
                                                </div>
                                                
                                                @if(isset($category['children']))
                                                    @foreach($category['children'] as $subCategory)
                                                        <div class="category-level-1 ps-3 mb-2">
                                                            
                                                            @if(isset($subCategory['children']) && count($subCategory['children']) > 0)
                                                                <!-- Есть дочерние категории - показываем как заголовок -->
                                                                <div class="fw-semibold text-muted">
                                                                    {{ $subCategory['name'] }}
                                                                </div>
                                                                
                                                                @foreach($subCategory['children'] as $childCategory)
                                                                    <div class="category-level-2 ps-4 mb-1">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input category-checkbox" 
                                                                                   type="checkbox" 
                                                                                   name="categories[]" 
                                                                                   value="{{ $childCategory['id'] }}"
                                                                                   id="edit_category_{{ $childCategory['id'] }}">
                                                                            <label class="form-check-label" for="edit_category_{{ $childCategory['id'] }}">
                                                                                {{ $childCategory['name'] }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <!-- Нет дочерних категорий - показываем как чекбокс -->
                                                                <div class="form-check">
                                                                    <input class="form-check-input category-checkbox" 
                                                                           type="checkbox" 
                                                                           name="categories[]" 
                                                                           value="{{ $subCategory['id'] }}"
                                                                           id="edit_category_{{ $subCategory['id'] }}">
                                                                    <label class="form-check-label fw-semibold" for="edit_category_{{ $subCategory['id'] }}">
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
                                                            <input class="form-check-input category-checkbox" 
                                                                   type="checkbox" 
                                                                   name="categories[]" 
                                                                   value="{{ $category['id'] }}"
                                                                   id="edit_category_{{ $category['id'] }}">
                                                            <label class="form-check-label" for="edit_category_{{ $category['id'] }}">
                                                                {{ $category['name'] }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group input-group-static mb-4">
                                <label for="editImages">Добавить изображения</label>
                                <input type="file" class="form-control" name="images[]" id="editImages" multiple>
                            </div>
                            
                            <div class="current-images">
                                <h6 class="mb-3">Текущие изображения:</h6>
                                <div class="d-flex flex-wrap" id="currentImagesContainer">
                                    <!-- Здесь будут отображаться текущие изображения -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-another-primary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn main-btn-active">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Modal для откликов -->
    <div class="modal fade" id="responsesModal" tabindex="-1" aria-labelledby="responsesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responsesModalLabel">Отклики на запрос</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="responsesList">
                        <!-- Здесь будут отображаться отклики -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-another-primary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Стили для таблицы */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        background-color: #f8f9fa;
    }
    
    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    /* Стили для модальных окон */
    .modal-content {
        border: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }
    
    .modal-footer {
        border-top: 1px solid #e9ecef;
    }
    
    /* Стили для Select2 */
    .select2-container--default .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    
    /* Стили для изображений */
    .current-images img {
        transition: transform 0.2s;
    }
    
    .current-images img:hover {
        transform: scale(1.05);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Выберите значения',
        allowClear: true
    });
    
    // Генерация текста через ИИ
    const titleInput = document.getElementById('title');
    const textArea = document.getElementById('description-input');
    const generateBtn = document.getElementById('generate-text-btn');
    const generateLabel = document.getElementById('generate-text-label');
    const generateSpinner = document.getElementById('generate-text-spinner');
    const submitBtn = document.getElementById('submit-btn-create');
    
    titleInput.addEventListener('input', function() {
        generateBtn.disabled = this.value.trim().length === 0;
    });
    
    generateBtn.addEventListener('click', function() {
        const title = titleInput.value.trim();
        if (!title) return;
        
        generateLabel.textContent = 'Генерация...';
        generateSpinner.classList.remove('d-none');
        generateBtn.disabled = true;
        submitBtn.disabled = true;
        
        fetch('/api/ai/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                prompt: `Придумай краткое продающее описание только текст для: "${title}"`
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.reply) {
                textArea.value = data.reply;
            } else if (data.error) {
                alert('Ошибка генерации: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при генерации текста');
        })
        .finally(() => {
            generateLabel.textContent = 'Спросить ИИ';
            generateSpinner.classList.add('d-none');
            generateBtn.disabled = false;
            submitBtn.disabled = false;
        });
    });
    
    // Заполнение данных для редактирования запроса
    const editRequestModal = document.getElementById('editRequestModal');
    editRequestModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const description = button.getAttribute('data-description');
        const categories = JSON.parse(button.getAttribute('data-categories'));
        const countries = JSON.parse(button.getAttribute('data-countries'));

        const form = document.getElementById('editRequestForm');
        form.action = form.action.replace('request_id', id);

        document.getElementById('editTitle').value = title;
        document.getElementById('editDescription').value = description;
        
        // Устанавливаем выбранные страны
        $('#editCountries').val(countries).trigger('change');
        
        // Отмечаем выбранные категории в чекбоксах
        categories.forEach(categoryId => {
            const checkbox = document.getElementById(`edit_category_${categoryId}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        
        // Устанавливаем выбранные страны
        $('#editCountries').val(countries).trigger('change');

        // Загружаем текущие изображения
        fetch(`/customer/requests/${id}/images`)
            .then(response => response.json())
            .then(images => {
                const container = document.getElementById('currentImagesContainer');
                container.innerHTML = '';
                
                images.forEach(image => {
                    const imageDiv = document.createElement('div');
                    imageDiv.className = 'position-relative me-2 mb-2';
                    imageDiv.style.width = '100px';
                    imageDiv.innerHTML = `
                        <img src="${image.path}" class="img-thumbnail" width="100">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                            onclick="deleteImage(${id}, ${image.id})">
                            &times;
                        </button>
                    `;
                    container.appendChild(imageDiv);
                });
            });
    });

    // Заполнение модалки откликов
    const responsesModal = document.getElementById('responsesModal');
    responsesModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const requestId = button.getAttribute('data-id');

        fetch(`/customer/requests/${requestId}/responses`)
            .then(response => response.json())
            .then(data => {
                const responsesList = document.getElementById('responsesList');
                responsesList.innerHTML = '';

                data.responses.forEach(response => {
                    if (response.status === 'ACTIVE') {
                        const card = document.createElement('div');
                        card.classList.add('card', 'mb-3');
                        card.innerHTML = `
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="${response.user.image_url}" class="avatar avatar-sm me-3" alt="user-image">
                                    <h5 class="card-title mb-0">${response.user.name}</h5>
                                </div>
                                <p class="card-text">${response.text}</p>
                                <button class="btn btn-success accept-response" 
                                    data-response-id="${response.id}" 
                                    data-request-id="${requestId}">
                                    <i class="material-icons text-sm me-1">check</i> Принять
                                </button>
                            </div>
                        `;
                        responsesList.appendChild(card);
                    }
                });

                // Обработчик для кнопки "Принять"
                document.querySelectorAll('.accept-response').forEach(button => {
                    button.addEventListener('click', function() {
                        const responseId = button.getAttribute('data-response-id');
                        const requestId = button.getAttribute('data-request-id');
                        
                        fetch(`/customer/requests/${requestId}/responses/${responseId}/accept`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ 
                                response_id: responseId, 
                                request_id: requestId 
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            window.location.href = '/chats/';
                        });
                    });
                });
            });
    });
});

function deleteImage(requestId, imageId) {
    if (confirm('Вы уверены, что хотите удалить это изображение?')) {
        fetch(`/customer/requests/${requestId}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}
</script>
@endsection