<?php

namespace App\Http\Controllers;

use App\Message;
use App\Chat;
use App\Events\SendMessage;
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

        $message = new Message();
        $message->body = request('message');

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
            DB::transaction(function () use($message, $chat){
                auth()->user()->messages()->save($message);
                $chat->messages()->save($message);
            }, 5);

            broadcast(new SendMessage($message, $chat->id));
            return redirect()->action('ChatController@show', $chat->id);
        } else
        {
            return redirect()->action('ChatController@index');
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
