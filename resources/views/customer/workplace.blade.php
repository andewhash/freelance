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
                                                <h6 class="mb-0">Ваши заявки</h6>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRequestModal">Создать заявку</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Название</th>
                                                <th>Цена</th>
                                                <th>Описание</th>
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($requests as $request)
                                                <tr>
                                                    <td>{{ $request->id }}</td>
                                                    <td>{{ $request->title }}</td>
                                                    <td>{{ $request->price }}</td>
                                                    <td>{{ $request->description }}</td>
                                                    <td>
                                                        <!-- Кнопка редактирования -->
                                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRequestModal" data-id="{{ $request->id }}" data-title="{{ $request->title }}" data-price="{{ $request->price }}" data-description="{{ $request->description }}">Редактировать</button>

                                                        <!-- Кнопка удаления -->
                                                        <form action="{{ route('customer.requests.destroy', $request->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Удалить</button>
                                                        </form>

                                                        <!-- Кнопка откликов, если есть хотя бы один отклик с ACTIVE статусом -->
                                                        @if($request->responses()->where('status', \App\Enum\Response\ResponseStatusEnum::ACTIVE)->count() > 0)
                                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#responsesModal" data-id="{{ $request->id }}">Отклики ({{ $request->responses()->where('status', \App\Enum\Response\ResponseStatusEnum::ACTIVE)->count() }})</button>
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
    </div>

    <!-- Modal для создания заявки -->
    <div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('customer.requests.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createRequestModalLabel">Создать заявку</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Название</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Цена</label>
                            <input type="number" class="form-control" name="price" id="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
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

    <!-- Modal для редактирования заявки -->
    <div class="modal fade" id="editRequestModal" tabindex="-1" aria-labelledby="editRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('customer.requests.update', 'request_id') }}" method="POST" id="editRequestForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRequestModalLabel">Редактировать заявку</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Название</label>
                            <input type="text" class="form-control" name="title" id="editTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Цена</label>
                            <input type="number" class="form-control" name="price" id="editPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Описание</label>
                            <textarea class="form-control" name="description" id="editDescription" rows="3" required></textarea>
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
            const description = button.getAttribute('data-description');

            const form = document.getElementById('editRequestForm');
            form.action = form.action.replace('request_id', id);

            document.getElementById('editTitle').value = title;
            document.getElementById('editPrice').value = price;
            document.getElementById('editDescription').value = description;
        });

        // Заполнение модалки откликов
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
                        // Только отклики со статусом ACTIVE
                        if (response.status === 'ACTIVE') {
                            const card = document.createElement('div');
                            card.classList.add('card', 'mb-3');
                            card.innerHTML = `
                            <div class="card-body">
                                <h5 class="card-title">${response.user.name}</h5>
                                <p class="card-text">${response.text}</p>
                                <button class="btn btn-success accept-response" data-response-id="${response.id}" data-request-id="${requestId}">Принять</button>
                            </div>
                        `;
                            responsesList.appendChild(card);
                        }
                    });

                    // Обработчик для кнопки "Принять"
                    const acceptButtons = document.querySelectorAll('.accept-response');

                    console.log(acceptButtons);
                    acceptButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const responseId = button.getAttribute('data-response-id');
                            const requestId = button.getAttribute('data-request-id');
                            try {
                                fetch(`/customer/requests/${requestId}/responses/${responseId}/accept`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({ response_id: responseId, request_id: requestId })
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        // Перенаправляем на страницу чатов после успешного создания
                                        window.location.href = '/chats/';
                                    });
                            } catch (e) {
                                console.log(e)
                            }
                            // Создание чата

                        });
                    });
                });
        });
    </script>
@endsection
