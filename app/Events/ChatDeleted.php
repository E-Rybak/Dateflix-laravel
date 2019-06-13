<?php

namespace App\Events;

use App\Chat;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ChatDeleted
{
    use Dispatchable, SerializesModels;

    public $chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }
}
