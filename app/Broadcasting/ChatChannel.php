<?php

namespace App\Broadcasting;

use App\User;
use App\Chat;
use App\Services\ValidatesChats;

class ChatChannel
{

    use ValidatesChats;

    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user, int $id)
    {
        $chat = Chat::findOrFail($id)->load('users');

        if (!$this->IsUserAChatParticipant($chat, $user))
        {
            return false;
        }

        return true;
    }
}
