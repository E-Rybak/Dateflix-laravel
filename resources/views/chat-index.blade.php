@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chats</div>

                <div class="card-body">
                    <ul>
                        @foreach($chats as $chat)

                        <li>
                            <a href="{{ route('chat.show', [$chat->id]) }}">
                                {{ $chat->name }}
                            </a>
                        </li>

                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
