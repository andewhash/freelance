@extends('layouts.app')

@section('content')
    <div class="main-content position-relative max-height-vh-100 h-100">
        <div class="container-fluid px-2 px-md-4">
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
                                                <h6 class="mb-0">Ваши объявления</h6>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createResponseModal">Создать Объявление</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Название</th>
                                                    <th>Текст</th>
                                                    <th>Количество</th>
                                                    <th>Категория</th>
                                                    <th>Доступность</th>
                                                    <th>Заявка</th>
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
                                                        <td>{{ $response->category->name ?? 'N/A' }}</td>
                                                        <td>{{ $response->is_exists ? 'Доступно' : 'Не доступно' }}</td>
                                                        <td>{{ $response->request->title ?? 'N/A' }}</td>
                                                        <td>
                                                            <!-- Кнопка редактирования -->
                                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editResponseModal" 
                                                                data-id="{{ $response->id }}" 
                                                                data-title="{{ $response->title }}" 
                                                                data-text="{{ $response->text }}" 
                                                                data-count="{{ $response->count }}"
                                                                data-category="{{ $response->category }}"
                                                                data-is_exists="{{ $response->is_exists }}"
                                                                data-request_id="{{ $response->request_id }}">Редактировать</button>

                                                            <!-- Кнопка удаления -->
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
        </div>
    </div>

    <!-- Modal для создания отклика -->
    <div class="modal fade" id="createResponseModal" tabindex="-1" aria-labelledby="createResponseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('seller.responses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createResponseModalLabel">Создать объявление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="mb-3">
                            <label for="title" class="form-label">Название</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Текст</label>
                            <textarea class="form-control" name="text" id="text" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="count" class="form-label">Количество</label>
                            <input type="number" class="form-control" name="count" id="count">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Категория</label>
                            <select class="form-control" name="category" id="category" required>
                                <option value="">Выберите категорию</option>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="is_exists" class="form-label">Доступность</label>
                            <select class="form-control" name="is_exists" id="is_exists">
                                <option value="1">Доступно</option>
                                <option value="0">Не доступно</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="request_id" class="form-label">Связанная заявка</label>
                            <select class="form-control" name="request_id" id="request_id">
                                <option value="">Не привязывать к заявке</option>
                                @foreach(\App\Models\Request::all() as $request)
                                    <option value="{{ $request->id }}">{{ $request->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Изображение</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal для редактирования отклика -->
    <div class="modal fade" id="editResponseModal" tabindex="-1" aria-labelledby="editResponseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('seller.responses.update', 'response_id') }}" method="POST" id="editResponseForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editResponseModalLabel">Редактировать Объявление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Название</label>
                            <input type="text" class="form-control" name="title" id="editTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editText" class="form-label">Текст</label>
                            <textarea class="form-control" name="text" id="editText" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editCount" class="form-label">Количество</label>
                            <input type="number" class="form-control" name="count" id="editCount">
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Категория</label>
                            <select class="form-control" name="category" id="editCategory" required>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editIsExists" class="form-label">Доступность</label>
                            <select class="form-control" name="is_exists" id="editIsExists">
                                <option value="1">Доступно</option>
                                <option value="0">Не доступно</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editRequestId" class="form-label">Связанная заявка</label>
                            <select class="form-control" name="request_id" id="editRequestId">
                                <option value="">Не привязывать к заявке</option>
                                @foreach(\App\Models\Request::all() as $request)
                                    <option value="{{ $request->id }}">{{ $request->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Изображение</label>
                            <input type="file" class="form-control" name="image" id="editImage">
                            <small class="text-muted">Оставьте пустым, чтобы сохранить текущее изображение</small>
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
            const category = button.getAttribute('data-category');
            const is_exists = button.getAttribute('data-is_exists');
            const request_id = button.getAttribute('data-request_id');

            const form = document.getElementById('editResponseForm');
            form.action = form.action.replace('response_id', id);

            document.getElementById('editTitle').value = title;
            document.getElementById('editText').value = text;
            document.getElementById('editCount').value = count;
            document.getElementById('editCategory').value = category;
            document.getElementById('editIsExists').value = is_exists;
            document.getElementById('editRequestId').value = request_id;
        });
    </script>
@endsection