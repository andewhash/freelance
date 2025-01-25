<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Вывод всех чатов пользователя
    public function index()
    {
        $user = Auth::user();

        // Получаем чаты, в которых участвует пользователь
        $chats = Chat::where('seller_id', $user->id)
            ->orWhere('customer_id', $user->id)
            ->with(['seller', 'customer'])
            ->get();

        return view('chats.index', compact('chats'));
    }

    // Отображение конкретного чата
    public function show(Chat $chat)
    {
        if (auth()->id() != $chat->seller_id && $chat->customer_id != auth()->id() ) {
            abort(403);
        }
        $chat->load(['messages.user']);

        return view('chats.show', compact('chat'));
    }

    // Отправка сообщения в чат
    public function send(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        ChatMessage::create([
            'chat_id' => $chat->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }
}
