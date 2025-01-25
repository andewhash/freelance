@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="row mt-4">
            <!-- Левая панель с чатами -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Чаты</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach(auth()->user()->chats as $userChat)
                                <li class="list-group-item {{ $userChat->id == $chat->id ? 'active' : '' }}">
                                    <a href="{{ route('profile.chats.show', $userChat->id) }}">
                                        {{ $userChat->seller_id == auth()->id() ? $userChat->customer->name : $userChat->seller->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Правая панель с чатом -->
            <div class="col-md-8">
                <div class="card" style="min-height: 500px">
                    <div class="card-header">
                        <h5>Чат с {{ $chat->seller_id == auth()->id() ? $chat->customer->name : $chat->seller->name }}</h5>
                        @if(auth()->user()->role == \App\Enum\User\UserRoleEnum::CUSTOMER)
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#orderModal">Создать заказ</button>
                        @endif
                    </div>
                    <div class="card-body chat-box" id="chatBox" style="max-height: 400px; overflow-y: auto;">
                        @foreach($chat->messages as $message)
                            <div class="d-flex mb-2 {{ $message->user_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                                <div class="p-2 border rounded {{ $message->user_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 70%;">
                                    <strong>{{ $message->user->name }}:</strong>
                                    <p class="mb-0">{{ $message->message }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <form id="messageForm" action="{{ route('profile.chats.send', $chat->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" id="messageInput" name="message" class="form-control" placeholder="Введите сообщение..." required>
                                <button style="height: 52px;    margin-bottom: 0;" type="submit" class="btn btn-primary">Отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для создания заказа -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Создать заказ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" action="{{route('customer.orders.create')}}">
                        <input type="hidden" value="{{$chat->seller_id}}" name="seller_id">
                        <div class="mb-3">
                            <label for="orderPrice" class="form-label">Название:</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="orderPrice" class="form-label">Стоимость (₽):</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="orderDeadline" class="form-label">Срок выполнения (дней):</label>
                            <input type="number" name="count_days" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="orderDescription" class="form-label">Описание заказа:</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Отправить заказ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Функция для прокрутки вниз
        function scrollToBottom() {
            let chatBox = document.querySelector("#chatBox");
            chatBox.scrollTop = chatBox.scrollHeight;
        }
        // Функция для обновления чата
        function updateChat() {
            fetch("{{ route('profile.chats.show', $chat->id) }}", {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    let newChatBox = doc.querySelector("#chatBox").innerHTML;
                    document.querySelector("#chatBox").innerHTML = newChatBox;
                    scrollToBottom(); // Прокрутка вниз после обновления
                })
                .catch(error => console.error("Ошибка обновления чата:", error));
        }

        // Запускаем обновление каждые 10 секунд
        setInterval(updateChat, 10000);

        // Автообновление чата после отправки сообщения
        document.querySelector("#messageForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch(this.action, {
                method: "POST",
                body: formData,
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
                .then(response => response.json())
                .then(data => {
                    document.querySelector("#messageInput").value = ""; // Очистка поля ввода
                    updateChat(); // Обновить чат сразу после отправки
                })
                .catch(error => console.error("Ошибка отправки сообщения:", error));
        });

        // Прокрутка вниз сразу при загрузке страницы
        document.addEventListener("DOMContentLoaded", scrollToBottom);
    </script>
@endsection
