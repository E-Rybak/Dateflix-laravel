<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Chat;

trait ValidatesChats {

	/**
	 * Check if a chat between the two users already exists
	 * 
	 * @param integer $user_id
	 * @return bool $chat_exists
	 */
	private function DoesChatExists($user_id)
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
        return $chat_exists;
	}

	/**
	 * Get and return the ids of a chats participant users
	 * 
	 * @param \Illuminate\Database\Eloquent\Collection $chats
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

    /**
     * Get and return the chat instances that are shared between an array of users and the  
     * authenticated user
     *
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getChatFromUserIds(array $ids) 
    {
        $chatUserCollection = collect();
        foreach ($ids as $id) {
            $chats = DB::table('chat_user')->where('user_id', $id)->get();
            $chatUserCollection->push($chats);
        }

        $trimmedCollection = $chatUserCollection->map(function ($item, $key) {
            return $item->map(function ($item, $key) {
                return ($item);
            });
        });

        $usersChats = collect();
        foreach ($trimmedCollection as $item) {
            foreach ($item as $value) {
                $usersChats->push($value);
            }
        }

        $authUsersChats = DB::table('chat_user')->where('user_id', auth()->id())->get();
        $commonChats = $usersChats->whereIn('chat_id', $authUsersChats->map(function ($item, $key) {
            return $item->chat_id;
        }));
        return Chat::findMany($commonChats->map(function ($item, $key) {
            return $item->chat_id;
        }));
    }
}

