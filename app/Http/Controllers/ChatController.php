<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
class ChatController extends Controller
{
    const CHATS_PER_PAGE = 5;
    const MESSAGES_PER_PAGE = 20;

    public function index()
    {
        $user = Auth::user();
        
        $chats = Chat::with(['seller', 'customer', 'latestMessage'])
            ->where(function($query) use ($user) {
                $query->where('seller_id', $user->id)
                      ->orWhere('customer_id', $user->id);
            })
            ->orderByDesc('updated_at')
            ->limit(self::CHATS_PER_PAGE)
            ->get();

        // Загружаем сообщения для первого чата, если есть
        $activeChat = $chats->first();
        $messages = collect();
        
        if ($activeChat) {
            $messages = $activeChat->messages()
                ->with('user')
                ->orderByDesc('created_at')
                ->limit(self::MESSAGES_PER_PAGE)
                ->get()
                ->reverse();
        }

        return view('chats.index', compact('chats', 'activeChat', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:users,id|different:seller_id',
        ]);

        $chat = Chat::firstOrCreate([
            'seller_id' => $request->seller_id,
            'customer_id' => $request->customer_id,
            'order_id' => 1
        ]);

        return response()->json(['chat_id' => $chat->id]);
    }

    public function send(Request $request, $id)
    {
        $chat = Chat::where('seller_id', auth()->user()->id)->orWhere('customer_id', auth()->user()->id)->findOrFail($id);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $chat->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($chat->id));


        $chat->touch();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'created_at' => $message->created_at->diffForHumans(),
                'user' => [
                    'id' => $message->user->id,
                    'name' => $message->user->name
                ]
            ]
        ]);
    }

    public function loadMoreChats(Request $request)
    {
        $user = Auth::user();
        $offset = $request->input('offset', 0);

        $chats = Chat::with(['seller', 'customer', 'latestMessage'])
            ->where(function($query) use ($user) {
                $query->where('seller_id', $user->id)
                      ->orWhere('customer_id', $user->id);
            })
            ->orderByDesc('updated_at')
            ->offset($offset)
            ->limit(self::CHATS_PER_PAGE)
            ->get();

        return response()->json($chats);
    }

    public function loadMoreMessages(Request $request, Chat $chat)
    {
        $offset = $request->input('offset', 0);

        $messages = $chat->messages()
            ->with('user')
            ->orderByDesc('created_at')
            ->offset($offset)
            ->limit(self::MESSAGES_PER_PAGE)
            ->get();

        return response()->json($messages);
    }

    public function getChat(Chat $chat)
    {
        $messages = $chat->messages()
            ->with('user')
            ->orderByDesc('created_at')
            ->limit(self::MESSAGES_PER_PAGE)
            ->get()
            ->reverse();

        return response()->json([
            'chat' => [
                'id' => $chat->id,
                'partner_name' => $chat->seller_id == auth()->id() 
                    ? $chat->customer->name 
                    : $chat->seller->name,
                'partner_id' => $chat->seller_id == auth()->id()
                    ? $chat->customer->id
                    : $chat->seller->id
            ],
            'messages' => $messages
        ]);
    }
}