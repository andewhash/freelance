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
                    <div class="card-body chats-list" style="overflow-y: auto; max-height: 500px;">
                        @if($chats->isEmpty())
                            <p>Пока тут пусто. Когда появятся чаты, они отобразятся здесь.</p>
                        @else
                            <ul class="list-group">
                                @foreach($chats as $chat)
                                    <li class="list-group-item chat-item {{ $activeChat && $activeChat->id == $chat->id ? 'active' : '' }}" 
                                        data-chat-id="{{ $chat->id }}">
                                        <a href="#" class="text-decoration-none">
                                            {{ $chat->seller_id == auth()->id() ? $chat->customer->name : $chat->seller->name }}
                                        </a>
                                        @if($chat->hasUnreadMessages(auth()->id()))
                                            <span class="badge bg-primary float-end">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        @endif
                                        <p class="text-muted small mb-0">
                                            {{ $chat->latestMessage ? Str::limit($chat->latestMessage->message, 30) : "Напишите первое сообщение..." }}
                                        </p>
                                        <p class="text-muted small mb-0">
                                            {{ $chat->latestMessage ? $chat->latestMessage->created_at->diffForHumans() : '' }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="text-center mt-3">
                                <button class="btn btn-sm btn-outline-primary load-more-chats">Загрузить еще</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Правая панель -->
            <div class="col-md-8">
                <div class="card chat-container" style="min-height: 500px">
                    @if($activeChat)
                        <div class="card-header">
                            <h5>Чат с {{ $activeChat->seller_id == auth()->id() ? $activeChat->customer->name : $activeChat->seller->name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="messages-container" style="overflow-y: auto; max-height: 400px;">
                                @foreach($messages as $message)
                                    <div class="message {{ $message->user_id == auth()->id() ? 'text-end' : 'text-start' }} mb-3">
                                        <div class="d-inline-block p-2 rounded {{ $message->user_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}">
                                            {{ $message->message }}
                                            <div class="text-muted small">{{ $message->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="message-input mt-3">
                                <textarea class="form-control mb-2" placeholder="Введите сообщение..." rows="2"></textarea>
                                <button class="btn btn-primary send-message">Отправить</button>
                            </div>
                        </div>
                    @else
                        <div class="card-header">
                            <h5>Выберите чат</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-center">Выберите чат слева для начала общения.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="/js/echo.js"></script>

<script>
    window.authId = {{ auth()->id() }};
    window.activeChatId = {{ $activeChat->id ?? 'null' }};
    window.initialChatsCount = {{ count($chats) }};
    window.initialMessagesCount = {{ $activeChat ? count($messages) : 0 }};
</script>
<script type="module"  src="/assets/js/chats.js"></script>

@endpush