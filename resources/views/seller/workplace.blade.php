@extends('layouts.app')

@section('content')
    <div class="main-content position-relative max-height-vh-100 h-100 mt-9">
        <!-- ... (остальная часть шапки как было) ... -->

        <div class="tab-content">
            <div class="tab-pane active" id="general" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h6 class="mb-0">Ваши объявления</h6>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createResponseModal">Создать Объявление</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Название</th>
                                            <th>Текст</th>
                                            <th>Количество</th>
                                            <th>Категории</th>
                                            <th>Страны</th>
                                            <th>Изображения</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($responses as $response)
                                            <tr>
                                                <td>{{ $response->id }}</td>
                                                <td>{{ $response->title }}</td>
                                                <td>{{ Str::limit($response->text, 50) }}</td>
                                                <td>{{ $response->count }}</td>
                                                <td>
                                                    @foreach($response->categories as $category)
                                                        <span class="badge bg-primary">{{ $category->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($response->countries as $country)
                                                        <span class="badge bg-success">{{ $country->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($response->images as $image)
                                                        <img src="{{ $image->path }}" width="50" class="me-2">
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editResponseModal" 
                                                        data-id="{{ $response->id }}" 
                                                        data-title="{{ $response->title }}" 
                                                        data-text="{{ $response->text }}" 
                                                        data-count="{{ $response->count }}"
                                                        data-categories="{{ $response->categories->pluck('id')->toJson() }}"
                                                        data-countries="{{ $response->countries->pluck('id')->toJson() }}"
                                                        data-is_exists="{{ $response->is_exists }}"
                                                        data-request_id="{{ $response->request_id }}">
                                                        Редактировать
                                                    </button>

                                                    <form action="{{ route('seller.responses.destroy', $response->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Удалить</button>
                                                    </form>
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

    <!-- Modal для создания отклика -->
    <div class="modal fade" id="createResponseModal" tabindex="-1" aria-labelledby="createResponseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('seller.responses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createResponseModalLabel">Создать объявление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Название*</label>
                                    <input type="text" class="form-control" name="title" id="title" required>
                                    <small class="text-muted">Укажите название товара/услуги</small>
                                </div>
                                <div class="mb-3">
                                    <label for="text" class="form-label">Текст*</label>
                                    <textarea class="form-control" name="text" id="text" rows="3" required></textarea>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" id="generate-text-btn" class="btn btn-sm btn-primary" disabled>
                                            <span id="generate-text-label">Спросить ИИ</span>
                                            <span id="generate-text-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="count" class="form-label">Количество</label>
                                    <input type="number" class="form-control" name="count" id="count">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categories" class="form-label">Категории*</label>
                                    <select class="form-control select2" name="categories[]" id="categories" multiple required>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="countries" class="form-label">Страны*</label>
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
                        <button type="submit" class="btn btn-primary" id="submit-btn">Создать</button>
                    </div>
                </div>
            </form>
            
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('title');
                const textArea = document.getElementById('text');
                const generateBtn = document.getElementById('generate-text-btn');
                const generateLabel = document.getElementById('generate-text-label');
                const generateSpinner = document.getElementById('generate-text-spinner');
                const submitBtn = document.getElementById('submit-btn');
            
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
    </div>

    <!-- Modal для редактирования отклика -->
    <div class="modal fade" id="editResponseModal" tabindex="-1" aria-labelledby="editResponseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('seller.responses.update', 'response_id') }}" method="POST" id="editResponseForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editResponseModalLabel">Редактировать Объявление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editTitle" class="form-label">Название*</label>
                                    <input type="text" class="form-control" name="title" id="editTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editText" class="form-label">Текст*</label>
                                    <textarea class="form-control" name="text" id="editText" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editCount" class="form-label">Количество</label>
                                    <input type="number" class="form-control" name="count" id="editCount">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editCategories" class="form-label">Категории*</label>
                                    <select class="form-control select2" name="categories[]" id="editCategories" multiple required style="width: 100%;">
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editCountries" class="form-label">Страны*</label>
                                    <select class="form-control select2" name="countries[]" id="editCountries" multiple required style="width: 100%;">
                                        @foreach(\App\Models\Country::all() as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <style>
                                /* Основные стили для Select2 */
                                .select2-container--default .select2-selection--multiple {
                                    min-height: 38px;
                                    border: 1px solid #ced4da;
                                    border-radius: 0.375rem;
                                    padding: 0.375rem 0.75rem;
                                }
                                
                                .select2-container--default.select2-container--focus .select2-selection--multiple {
                                    border-color: #86b7fe;
                                    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
                                }
                                
                                /* Стили для выбранных элементов */
                                .select2-container--default .select2-selection--multiple .select2-selection__choice {
                                    background-color: #e9ecef;
                                    border: 1px solid #ced4da;
                                    border-radius: 0.25rem;
                                    padding: 0 0.5rem;
                                    margin-right: 0.5rem;
                                    margin-top: 0.25rem;
                                }
                                
                                /* Стили для крестика удаления */
                                .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                                    color: #6c757d;
                                    margin-right: 0.25rem;
                                }
                                
                                /* Стили для поля поиска */
                                .select2-container--default .select2-search--inline .select2-search__field {
                                    margin-top: 0.375rem;
                                    height: 1.5em;
                                }
                                
                                /* Фиксированная ширина выпадающего списка */
                                .select2-container {
                                    width: 100% !important;
                                }
                                
                                /* Выравнивание элементов в выпадающем списке */
                                .select2-results__option {
                                    padding: 0.5rem 1rem;
                                }
                            </style>
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

        <script>
            // Заполнение данных для редактирования отклика
            const editResponseModal = document.getElementById('editResponseModal');
            editResponseModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');
                const text = button.getAttribute('data-text');
                const count = button.getAttribute('data-count');
                const categories = JSON.parse(button.getAttribute('data-categories'));
                const countries = JSON.parse(button.getAttribute('data-countries'));
                const is_exists = button.getAttribute('data-is_exists');
                const request_id = button.getAttribute('data-request_id');

                const form = document.getElementById('editResponseForm');
                form.action = form.action.replace('response_id', id);

                document.getElementById('editTitle').value = title;
                document.getElementById('editText').value = text;
                document.getElementById('editCount').value = count;
                
                // Устанавливаем выбранные категории
                const categorySelect = $('#editCategories');
                categorySelect.val(categories).trigger('change');
                
                // Устанавливаем выбранные страны
                const countrySelect = $('#editCountries');
                countrySelect.val(countries).trigger('change');
                
                document.getElementById('editIsExists').value = is_exists;
                document.getElementById('editRequestId').value = request_id;

                // Загружаем текущие изображения
                fetch(`/seller/responses/${id}/images`)
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

            function deleteImage(responseId, imageId) {
                if (confirm('Вы уверены, что хотите удалить это изображение?')) {
                    fetch(`/seller/responses/${responseId}/images/${imageId}`, {
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