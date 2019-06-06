<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->load('chats');
        $chats = $user->chats->load('users');
        $chat_ids = $chats->map(function ($item, $key) {
            return $item->users->map(function ($item, $key) {
                return $item->id;
            });
        });
        
        $id = 2; // This id should normally come from a request, and is the id of the other participant in the chat. IE, not the authed user.
        $chat_exists = false;
        foreach ($chat_ids as $chat_id)
        {
            if ($chat_id->contains($id) && $chat_id->contains(auth()->id()))
            {
                $chat_exists = true;
            }
        }
        if ($chat_exists) {
            return "Chat already exists";
        } else {
            return "Chat created!";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
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
