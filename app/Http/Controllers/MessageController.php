<?php

namespace App\Http\Controllers;

use App\Message;
use App\Chat;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\ValidatesChats;

class MessageController extends Controller
{

    use ValidatesChats;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $chat = Chat::findOrFail(request('chat_id'));
        $result = $this->IsUserAChatParticipant($chat, auth()->user());
        /*
        1. Validate users authorization to interact with the chat.
        2. Save message to the database.
        3. Attach the user.
        4. Attach the chat.
        5. Broadcast the event.
        5. return chat-show view.
        */
        if ($result)
        {
            DB::transaction(function () {
                $message = new Message();
                $message->body = request('message');
                auth()->user()->messages()->save($message);
                Chat::findOrFail(request('chat_id'))->messages()->save($message);
            }, 5);

            return redirect()->action('ChatController@show', $chat->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
