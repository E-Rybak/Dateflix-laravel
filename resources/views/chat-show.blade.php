@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <chat-show _chat="{{ $chat }}" _username="{{ auth()->user()->name }}"></chat-show>
        </div>
    </div>
</div>
@endsection