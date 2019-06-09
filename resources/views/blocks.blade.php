@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your blocked users</div>

                <div class="card-body">
                    <ul>
                        @foreach($users as $user)
                            <li>
                                <form class="form-inline" action="{{ route('block.destroy') }}" method="post">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <span>{{ $user->name }}</span>
                                        &nbsp;
                                        <input type="hidden" name="blocked_user_id" value="{{ $user->id }}">
                                        <button class="btn btn-danger" style="margin: 1px">Unblock</button>
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
