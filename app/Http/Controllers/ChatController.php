<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use App\Services\ValidatesChats;


class ChatController extends Controller
{

    use ValidatesChats;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = Chat::get();
        return view('chat-index', compact('chats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $likedUserId = request('user_id');

        if ((int)$likedUserId === (int) auth()->id())
        {
            return "User id is the same as auth id";
        }

        if ($this->DoesChatExists($likedUserId))
        {
            $chats = $this->getChatFromUserIds($userIds = array($likedUserId));
            if ((int)$chats->count() == 1)
            {
                $chat = $chats->first();
                return redirect()->action('ChatController@show', $chat->id);
            }
            //TODO: two users can have multiple chat instances.
            return "TODO: two user can have multiple chat instances - from ChatController line 44";
        }
        $chat = new Chat();
        $chat->name = auth()->user()->name;
        $chat->save();
        $participants = collect([auth()->user(), User::findOrFail($likedUserId)]);
        foreach ($participants as $participant) {
            $chat->users()->save($participant);
        }
        return redirect()->action('ChatController@show', $chat->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $chat = Chat::findOrFail($id)->load(['users', 'messages']);
        return view('chat-show', compact('chat'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
