<?php

namespace App\Services;

trait ValidatesChats {

	/**
	 * Check if a chat between the two users already exists
	 * 
	 * @param integer $user_id
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	private function CheckChatExistence($user_id)
	{
        if ((int)$user_id === (int) auth()->id())
        {
            return "User id is the same as auth id";
        }

        $user = auth()->user()->load('chats');
        $chats = $user->chats->load('users');
        
        $chat_participants = $this->getChatParticipantsIds($chats);

        $chat_exists = false;
        foreach ($chat_participants as $participant)
        {
            if ($participant->contains($user_id) && $participant->contains(auth()->id()))
            {
                $chat_exists = true;
                break;
            }
        }
        if ($chat_exists) {
            return "Chat already exists";
        } else {
            return "Chat created!";
        }
	}

	/**
	 * Get and return the ids of a chats participant users
	 * 
	 * @param Chat collection $chats
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	private function getChatParticipantsIds($chats)
	{
        $chat_participants = $chats->map(function ($chat, $key) {
            return $chat->users->map(function ($user, $key) {
                return $user->id;
            });
        });

        return $chat_participants;
	}

}

