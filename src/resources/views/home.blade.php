@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    <form action="/send_mail" method="POST">
        @csrf
        <label>宛先</label><select name="to">
            @foreach($users_list as $user_data)
            @if($loop->iteration==1)
            <option selected value="{{ $user_data->email }}">{{ $user_data->email }}</option>
            @else
            <option value="{{ $user_data->email }}">{{ $user_data->email }}</option>
            @endif
            @endforeach
        </select><br>
        <label>タイトル</label><input type="text" name="title"><br>
        <label>本文</label><textarea name="message"></textarea><br>
        <input type="submit" value="メール送信">
    </form>
</div>
@endsection
