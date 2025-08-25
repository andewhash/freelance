let currentChatId = window.activeChatId || null;
let isLoading = false;
let chatsOffset = window.initialChatsCount || 0;
let messagesOffset = window.initialMessagesCount || 0;

// ✅ Когда DOM готов
document.addEventListener('DOMContentLoaded', () => {
    window.Echo.private('chat.1')
        .listen('MessageSent', (e) => { console.log(e); });


    const loadMoreChatsBtn = document.querySelector('.load-more-chats');

    if (loadMoreChatsBtn) {
        loadMoreChatsBtn.addEventListener('click', function () {
            if (isLoading) return;

            isLoading = true;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Загрузка...';

            fetch(`/profile/chats/load-more?offset=${chatsOffset}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        chatsOffset += data.length;
                        renderChats(data);
                    } else {
                        loadMoreChatsBtn.style.display = 'none';
                    }
                })
                .finally(() => {
                    isLoading = false;
                    loadMoreChatsBtn.disabled = false;
                    loadMoreChatsBtn.textContent = 'Загрузить еще';
                });
        });
    }

    document.addEventListener('click', function (e) {
        if (e.target.closest('.chat-item')) {
            e.preventDefault();
            const chatId = e.target.closest('.chat-item').dataset.chatId;
            if (currentChatId === chatId) return;

            currentChatId = chatId;
            document.querySelectorAll('.chat-item').forEach(item => item.classList.remove('active'));
            e.target.closest('.chat-item').classList.add('active');
            loadChat(chatId);
        }
    });

    const sendBtn = document.querySelector('.send-message');
    if (sendBtn) {
        sendBtn.addEventListener('click', () => {
            const textarea = document.querySelector('.message-input textarea');
            const message = textarea.value.trim();

            if (message && currentChatId) {
                fetch(`/profile/chats/${currentChatId}/send/`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message })
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        textarea.value = '';
                        appendMessage(response.message);
                    }
                });
            }
        });
    }
});

function loadChat(chatId) {
    fetch(`/profile/chats/${chatId}`)
        .then(res => res.json())
        .then(data => {
            const header = document.querySelector('.chat-container .card-header h5');
            header.textContent = 'Чат с ' + data.chat.partner_name;

            const messagesContainer = document.querySelector('.messages-container');
            let messagesHtml = '';

            if (data.messages.length > 0) {
                data.messages.forEach(message => {
                    messagesHtml += renderMessage(message);
                });
            } else {
                messagesHtml = '<p class="text-center">Нет сообщений</p>';
            }

            messagesContainer.innerHTML = messagesHtml;
            currentChatId = chatId;
            // subscribeToChat(chatId);

            document.querySelector('.message-input').style.display = 'block';
            scrollToBottom();
        });
}

function renderChats(chats) {
    const list = document.querySelector('.chats-list ul');
    let html = '';

    chats.forEach(chat => {
        html += `
            <li class="list-group-item chat-item" data-chat-id="${chat.id}">
                <a href="#" class="text-decoration-none">
                    ${chat.seller_id == window.authId ? chat.customer.name : chat.seller.name}
                </a>
                ${chat.has_unread ? '<span class="badge bg-primary float-end"><i class="fas fa-check"></i></span>' : ''}
                <p class="text-muted small mb-0">${chat.latest_message ? chat.latest_message.message.substring(0, 30) + (chat.latest_message.message.length > 30 ? '...' : '') : 'Напишите первое сообщение...'}</p>
                <p class="text-muted small mb-0">${chat.latest_message ? chat.latest_message.created_at : ''}</p>
            </li>
        `;
    });

    list.insertAdjacentHTML('beforeend', html);
}

function renderMessage(message) {
    const isMe = message.user_id == window.authId;
    return `
        <div class="message ${isMe ? 'text-end' : 'text-start'} mb-3">
            <div class="d-inline-block p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-light'}">
                ${message.message}
                <div class="text-muted small">${message.created_at}</div>
            </div>
        </div>
    `;
}


function subscribeToChat(chatId) {
    if (!window.Echo) return;
            // Добавляем сообщение только если это текущий чат
            console.log('123131')

    window.Echo.private(`chat.${chatId}`)
        .listen('.message.sent', (e) => {
            console.log('asdadadads')
            // Добавляем сообщение только если это текущий чат
            if (chatId == currentChatId) {
                appendMessage({
                    id: e.message.id,
                    message: e.message.message,
                    created_at: e.message.created_at,
                    user_id: e.message.user.id,
                    user: e.message.user
                });
            } else {
                // Можно добавить индикатор непрочитанных сообщений для других чатов
                markChatAsUnread(e.chatId);
            }
        });
}

function appendMessage(message) {
    const messagesContainer = document.querySelector('.messages-container');
    messagesContainer.insertAdjacentHTML('beforeend', renderMessage(message));
    scrollToBottom();
}

function scrollToBottom() {
    const container = document.querySelector('.messages-container');
    container.scrollTop = container.scrollHeight;
}
