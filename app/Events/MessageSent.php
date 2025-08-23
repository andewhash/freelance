<?php 
namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatId;

    public function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    public function broadcastOn()
    {
         \Log::info("Broadcasting MessageSent to chat {$this->chatId}");
        return new PrivateChannel('chat.1');
    }
}
