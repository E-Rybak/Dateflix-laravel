<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Message;

class DeleteChatRelations
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->chat->users()->detach();
        $messages = $event->chat->messages;
        $message_ids = $messages->map(function ($item, $key) {
            return $item->id;
        });
        Message::whereIn('id', $message_ids)->delete();
    }
}
