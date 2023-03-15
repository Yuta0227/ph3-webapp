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
    <div><a href="{{route('webapp')}}">webapp</a></div>
    <form action="{{route('logout')}}" method="POST">
        @csrf
        <div style="justify-content:center;display:flex;margin:200px 0;">
            <input name="logout" style="background-color:yellow;" type="submit" value="ログアウトする"></input>
        </div>
    </form>
    <form id="manage-user-form">
        @csrf
        @foreach($all_users as $user)
        {{$user}}
        <div style="display:flex;">
            <div>{{$user->name}}</div>
            <div>{{$user->email}}</div>
            @if($user->admin_bool==1)
            <div>管理者</div>
            @else
            <div>一般ユーザー</div>
            @endif
            <form></form>
        </div>
        @endforeach
    </form>

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