@extends('layouts.app')

@section('content')
<style>
    .list-group-item.active {
        border-color: #f69459 !important;
        color: white !important;
        transition: .3 all ease;
        background-color: #f69459 !important;
    }
</style>
<div class="container-fluid px-2 px-md-4" style="margin-top: 120px !important">
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
                        <ul class="list-group" id="chat-list">
                            @foreach($chats as $chat)
                                <li class="list-group-item chat-item {{ $activeChat && $activeChat->id == $chat->id ? 'active' : '' }}"
                                    data-chat-id="{{ $chat->id }}">
                                    <a href="#" class="text-decoration-none">
                                        {{ $chat->seller_id == auth()->id() ? $chat->customer->name : $chat->seller->name }}
                                    </a>
                                    <p class="text-muted small mb-0">
                                        {{ $chat->latestMessage ? Str::limit($chat->latestMessage->message, 30) : "Напишите первое сообщение..." }}
                                    </p>
                                    <p class="text-muted small mb-0">
                                        {{ $chat->latestMessage ? $chat->latestMessage->created_at->diffForHumans() : '' }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Правая панель -->
        <div class="col-md-8">
            <div class="card chat-container" style="min-height: 500px">
                @if($activeChat)
                    <div class="card-header">
                        <h5 id="chat-title">Чат с {{ $activeChat->seller_id == auth()->id() ? $activeChat->customer->name : $activeChat->seller->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div id="messages-container" class="messages-container" style="overflow-y: auto; max-height: 400px;">
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
                            <textarea id="message-text" class="form-control mb-2" placeholder="Введите сообщение..." rows="2"></textarea>
                            <button id="send-message" class="btn btn-primary">Отправить</button>
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
<script>
    let activeChatId = {{ $activeChat->id ?? 'null' }};
let chatInterval = null;
let messageInterval = null;
let offsetChats = {{ count($chats) }};
const CHATS_REFRESH_INTERVAL = 15000;
const MESSAGES_REFRESH_INTERVAL = 5000;

const chatList = document.getElementById('chat-list');
const messagesContainer = document.getElementById('messages-container');
let currentActiveChatItem = null;
let lastMessageId = {{ $messages->last()->id ?? 0 }}; // ID последнего сообщения

// Устанавливаем активный чат при загрузке
if (activeChatId) {
    currentActiveChatItem = document.querySelector(`.chat-item[data-chat-id="${activeChatId}"]`);
    if (currentActiveChatItem) {
        currentActiveChatItem.classList.add('active');
    }
}

// Автообновление списка чатов
function startChatsRefresh() {
    if (chatInterval) clearInterval(chatInterval);
    chatInterval = setInterval(loadChats, CHATS_REFRESH_INTERVAL);
}

function loadChats() {
    fetch(`{{ route('profile.chats.loadMore') }}?offset=0`)
        .then(res => res.json())
        .then(chats => {
            chatList.innerHTML = '';
            chats.forEach(chat => {
                const li = createChatListItem(chat);
                chatList.appendChild(li);
            });
            
            // Восстанавливаем активный чат после обновления
            if (activeChatId) {
                currentActiveChatItem = document.querySelector(`.chat-item[data-chat-id="${activeChatId}"]`);
                if (currentActiveChatItem) {
                    currentActiveChatItem.classList.add('active');
                }
            }
        });
}

// Создание элемента списка чатов
function createChatListItem(chat) {
    const li = document.createElement('li');
    li.className = 'list-group-item chat-item';
    li.dataset.chatId = chat.id;
    
    // Проверяем, является ли этот чат активным
    const isActive = activeChatId === chat.id;
    if (isActive) {
        li.classList.add('active');
    }
    
    li.innerHTML = `
        <a href="#" class="text-decoration-none">${chat.seller_id === {{ auth()->id() }} ? chat.customer.name : chat.seller.name}</a>
        <p class="text-muted small mb-0">${chat.latest_message ? (chat.latest_message.message || '').substring(0, 30) : 'Напишите первое сообщение...'}</p>
        <p class="text-muted small mb-0">${chat.latest_message ? formatDate(chat.latest_message.created_at) : ''}</p>
    `;
    
    li.addEventListener('click', (e) => {
        e.preventDefault();
        if (!isActive) {
            switchChat(chat.id);
        }
    });
    
    return li;
}

// Форматирование даты
function formatDate(dateString) {
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return '';
    
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);
    
    if (diffMins < 1) return 'только что';
    if (diffMins < 60) return `${diffMins} мин назад`;
    if (diffHours < 24) return `${diffHours} ч назад`;
    if (diffDays < 7) return `${diffDays} дн назад`;
    
    return date.toLocaleDateString();
}

// Переключение чата
function switchChat(chatId) {
    if (chatId === activeChatId) return;
    
    if (messageInterval) clearInterval(messageInterval);
    
    // Убираем активный класс с предыдущего чата
    if (currentActiveChatItem) {
        currentActiveChatItem.classList.remove('active');
    }
    
    // Устанавливаем новый активный чат
    activeChatId = chatId;
    currentActiveChatItem = document.querySelector(`.chat-item[data-chat-id="${chatId}"]`);
    if (currentActiveChatItem) {
        currentActiveChatItem.classList.add('active');
    }

    fetch(`/profile/chats/${chatId}`)
        .then(res => {
            if (!res.ok) throw new Error('Chat not found');
            return res.json();
        })
        .then(data => {
            document.getElementById('chat-title').innerText = 'Чат с ' + data.chat.partner_name;
            messagesContainer.innerHTML = '';
            
            // Убеждаемся, что messages - это массив
            const messages = Array.isArray(data.messages) ? data.messages : Object.values(data.messages || {});
            
            // Устанавливаем lastMessageId для нового чата
            if (messages.length > 0) {
                lastMessageId = messages[messages.length - 1].id;
            } else {
                lastMessageId = 0;
            }
            
            messages.forEach(msg => {
                appendMessage(msg);
            });
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            startMessagesRefresh(chatId);
        })
        .catch(error => {
            console.error('Error loading chat:', error);
            alert('Не удалось загрузить чат');
        });
}

function startMessagesRefresh(chatId) {
    if (messageInterval) clearInterval(messageInterval);
    
    messageInterval = setInterval(() => {
        fetch(`/profile/chats/${chatId}/new-messages?last_id=${lastMessageId}`)
            .then(res => {
                if (!res.ok) throw new Error('Failed to fetch new messages');
                return res.json();
            })
            .then(newMessages => {
                // Проверяем, что newMessages - массив
                const messagesArray = Array.isArray(newMessages) ? newMessages : Object.values(newMessages || {});
                
                if (messagesArray.length > 0) {
                    // Добавляем только новые сообщения
                    messagesArray.forEach(msg => {
                        appendMessage(msg);
                        // Обновляем lastMessageId
                        if (msg.id > lastMessageId) {
                            lastMessageId = msg.id;
                        }
                    });
                    
                    // Скроллим вниз если пользователь был внизу
                    const isAtBottom = messagesContainer.scrollHeight - messagesContainer.scrollTop <= messagesContainer.clientHeight + 100;
                    if (isAtBottom) {
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                    
                    // Обновляем список чатов для отображения последнего сообщения
                    updateChatListLastMessage(chatId, messagesArray[messagesArray.length - 1]);
                }
            })
            .catch(error => {
                console.error('Error fetching new messages:', error);
            });
    }, MESSAGES_REFRESH_INTERVAL);
}

// Обновляем последнее сообщение в списке чатов
function updateChatListLastMessage(chatId, lastMessage) {
    const chatItem = document.querySelector(`.chat-item[data-chat-id="${chatId}"]`);
    if (chatItem) {
        const messageElement = chatItem.querySelector('.text-muted.small.mb-0:first-child');
        const timeElement = chatItem.querySelector('.text-muted.small.mb-0:last-child');
        
        if (messageElement) {
            messageElement.textContent = lastMessage.message.substring(0, 30);
        }
        if (timeElement) {
            timeElement.textContent = formatDate(lastMessage.created_at);
        }
    }
}

function appendMessage(msg, isUppend = false) {
    const div = document.createElement('div');
    let isOwnMessage = true;

    if (!isUppend) {
        isOwnMessage = msg.user_id === {{ auth()->id() }};
    } 
    div.className = `message ${isOwnMessage ? 'text-end' : 'text-start'} mb-3`;
    div.innerHTML = `
        <div class="d-inline-block p-2 rounded ${isOwnMessage ? 'bg-primary text-white' : 'bg-light'}" style="max-width: 70%;">
            ${msg.message}
            <div class="text-muted small">${formatDate(msg.created_at)}</div>
        </div>
    `;
    messagesContainer.appendChild(div);
}

// Отправка сообщения
document.getElementById('send-message')?.addEventListener('click', () => {
    const textArea = document.getElementById('message-text');
    const message = textArea.value.trim();
    if (!message || !activeChatId) return;

    fetch(`/profile/chats/${activeChatId}/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message })
    })
    .then(res => res.json())
    .then(data => {
        // Добавляем сообщение в чат
        appendMessage(data.message, true);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        textArea.value = '';
        
        // Обновляем lastMessageId
        if (data.message.id > lastMessageId) {
            lastMessageId = data.message.id;
        }
        
        // Обновляем список чатов
        updateChatListLastMessage(activeChatId, data.message);
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('Не удалось отправить сообщение');
    });
});

// Старт автообновления чатов
startChatsRefresh();

// Навешиваем клики на существующие чаты
document.querySelectorAll('.chat-item').forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        const chatId = item.dataset.chatId;
        if (chatId !== activeChatId) {
            switchChat(chatId);
        }
    });
});

// Загрузить еще чаты
document.getElementById('load-more-chats')?.addEventListener('click', () => {
    fetch(`{{ route('profile.chats.loadMore') }}?offset=${offsetChats}`)
        .then(res => res.json())
        .then(newChats => {
            newChats.forEach(chat => {
                const li = createChatListItem(chat);
                chatList.appendChild(li);
            });
            offsetChats += newChats.length;
            
            if (newChats.length < {{ \App\Http\Controllers\ChatController::CHATS_PER_PAGE }}) {
                document.getElementById('load-more-chats').style.display = 'none';
            }
        });
});

// Автообновление сообщений для активного чата при загрузке страницы
if (activeChatId) startMessagesRefresh(activeChatId);

// Обработка нажатия Enter для отправки сообщения
document.getElementById('message-text')?.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('send-message').click();
    }
});
</script>
@endpush
