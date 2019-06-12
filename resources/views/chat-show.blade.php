@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $chat->name }}</div>

                <div class="card-body">

                    <h6><b>Participants</b></h6>
                    <ol>
                        @foreach($chat->users as $user)
                        <li>
                            {{ $user->name }}
                        </li>
                        @endforeach
                    </ol>
                    <h6><b>Messages</b></h6>   
                    <ul>
                        @foreach($chat->messages as $message)
                            <li>
                                {{ $message->body }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <form method="post" action="{{ route('message.store') }}">
                    @csrf
                    <input type="text" name="message" required>
                    <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                    <button class="btn btn-success">Send message</button>
                </form>
                <form method="post" action="{{ route('chat.destroy') }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                    <button class="btn btn-danger">Delete chat permanently</button>                
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    
</script>