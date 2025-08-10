@extends('layouts.app')

@section('content')
<div class="main-content position-relative max-height-vh-100 h-100 mt-9">
    <div class="container-fluid px-2 px-md-4">
        <!-- Шапка профиля -->
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        
        <div class="card card-body mx-2 mx-md-2 mt-n6">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/storage/{{ auth()->user()->image_url }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="mb-0 font-weight-normal text-sm">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
            
            <div class="tab-content">
                <div class="tab-pane active" id="general" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-0">Ваши заявки</h6>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRequestModal">Создать заявку</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Название</th>
                                                <th>Категории</th>
                                                <th>Страны</th>
                                                <th>Изображения</th>
                                                <th>Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requests as $request)
                                                <tr>
                                                    <td>{{ $request->id }}</td>
                                                    <td>{{ $request->title }}</td>
                                                    <td>
                                                        @foreach($request->categories as $category)
                                                            <span class="badge bg-primary">{{ $category->name }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($request->countries as $country)
                                                            <span class="badge bg-success">{{ $country->name }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($request->images as $image)
                                                            <img src="{{ $image->path }}" width="50" class="me-2">
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRequestModal" 
                                                            data-id="{{ $request->id }}" 
                                                            data-title="{{ $request->title }}" 
                                                            data-categories="{{ $request->categories->pluck('id')->toJson() }}"
                                                            data-countries="{{ $request->countries->pluck('id')->toJson() }}"
                                                            data-description="{{ $request->description }}">
                                                            Редактировать
                                                        </button>

                                                        <form action="{{ route('customer.requests.destroy', $request->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Удалить</button>
                                                        </form>

                                                        @if($request->responses()->where('status', \App\Enum\Response\ResponseStatusEnum::ACTIVE)->count() > 0)
                                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#responsesModal" data-id="{{ $request->id }}">
                                                                Отклики ({{ $request->responses()->where('status', \App\Enum\Response\ResponseStatusEnum::ACTIVE)->count() }})
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal для создания заявки -->
    <div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('customer.requests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createRequestModalLabel">Создать заявку</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Название *</label>
                                    <input type="text" class="form-control" name="title" id="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Описание *</label>
                                    <textarea class="form-control" name="description" id="description-input" rows="3" required></textarea>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" id="generate-text-btn" class="btn btn-sm btn-primary" disabled>
                                            <span id="generate-text-label">Спросить ИИ</span>
                                            <span id="generate-text-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                        </button>
                                    </div>
                                </div>
                               
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categories" class="form-label">Категории *</label>
                                    <select class="form-control select2" name="categories[]" id="categories" multiple required>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="countries" class="form-label">Страны *</label>
                                    <select class="form-control select2" name="countries[]" id="countries" multiple required>
                                        @foreach(\App\Models\Country::all() as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                             
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="images" class="form-label">Изображения</label>
                                    <input type="file" class="form-control" name="images[]" id="images" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" id="submit-btn-create" class="btn btn-primary">Создать</button>
                    </div>


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const titleInput = document.getElementById('title');
                            const textArea = document.getElementById('description-input');
                            const generateBtn = document.getElementById('generate-text-btn');
                            const generateLabel = document.getElementById('generate-text-label');
                            const generateSpinner = document.getElementById('generate-text-spinner');
                            const submitBtn = document.getElementById('submit-btn-create');
                        
                            // Активация кнопки при вводе названия
                            titleInput.addEventListener('input', function() {
                                generateBtn.disabled = this.value.trim().length === 0;
                            });
                        
                            // Генерация текста через ИИ
                            generateBtn.addEventListener('click', function() {
                                const title = titleInput.value.trim();
                                if (!title) return;
                        
                                // Показываем спиннер и блокируем кнопки
                                generateLabel.textContent = 'Генерация...';
                                generateSpinner.classList.remove('d-none');
                                generateBtn.disabled = true;
                                submitBtn.disabled = true;
                        
                                // Запрос к API
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
                                    // Восстанавливаем состояние кнопок
                                    generateLabel.textContent = 'Спросить ИИ';
                                    generateSpinner.classList.add('d-none');
                                    generateBtn.disabled = false;
                                    submitBtn.disabled = false;
                                });
                            });
                        });
                        </script>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal для редактирования заявки -->
    <div class="modal fade" id="editRequestModal" tabindex="-1" aria-labelledby="editRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('customer.requests.update', 'request_id') }}" method="POST" id="editRequestForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRequestModalLabel">Редактировать заявку</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editTitle" class="form-label">Название *</label>
                                    <input type="text" class="form-control" name="title" id="editTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editDescription" class="form-label">Описание *</label>
                                    <textarea class="form-control" name="description" id="editDescription" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editCategories" class="form-label">Категории *</label>
                                    <select class="form-control select2" name="categories[]" id="editCategories" multiple required>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editCountries" class="form-label">Страны *</label>
                                    <select class="form-control select2" name="countries[]" id="editCountries" multiple required>
                                        @foreach(\App\Models\Country::all() as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="editImages" class="form-label">Добавить изображения</label>
                                    <input type="file" class="form-control" name="images[]" id="editImages" multiple>
                                </div>
                                <div class="current-images">
                                    <h6>Текущие изображения:</h6>
                                    <div class="d-flex flex-wrap" id="currentImagesContainer">
                                        <!-- Здесь будут отображаться текущие изображения -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal для откликов -->
    <div class="modal fade" id="responsesModal" tabindex="-1" aria-labelledby="responsesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responsesModalLabel">Отклики на заявку</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="responsesList">
                        @csrf
                        <!-- Здесь будут отображаться отклики -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Заполнение данных для редактирования заявки
        const editRequestModal = document.getElementById('editRequestModal');
        editRequestModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const price = button.getAttribute('data-price');
            const categories = JSON.parse(button.getAttribute('data-categories'));
            const countries = JSON.parse(button.getAttribute('data-countries'));
            const status = button.getAttribute('data-status');
            const description = button.getAttribute('data-description');

            const form = document.getElementById('editRequestForm');
            form.action = form.action.replace('request_id', id);

            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            
            // Устанавливаем выбранные категории
            $('#editCategories').val(categories).trigger('change');
            
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
                                    <h5 class="card-title">${response.user.name}</h5>
                                    <p class="card-text">${response.text}</p>
                                    <button class="btn btn-success accept-response" 
                                        data-response-id="${response.id}" 
                                        data-request-id="${requestId}">
                                        Принять
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

        
    </script>
@endsection