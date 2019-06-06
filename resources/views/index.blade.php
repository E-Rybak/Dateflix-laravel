@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    <ul>
                        @foreach($users as $user)
                            <li>
                                <form class="form-inline" action="{{ route('like') }}" method="post">
                                    @csrf
                                    <span>{{ $user->name }}</span>
                                    &nbsp;
                                    <input type="hidden" name="liked_user_id" value="{{ $user->id }}">
                                    <button class="btn btn-success" style="margin: 1px">Like</button>
                                </form>
                                <form class="form-inline" action="{{ route('block.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button class="btn btn-danger" style="margin: 1px">Block</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
