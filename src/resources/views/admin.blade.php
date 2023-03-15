<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div>
    <form action="{{route('logout')}}" method="post">
      @csrf
      <input type="submit" value="ログアウト">
    </form>
    <a href="{{route('webapp')}}">webapp</a>
    @if(session('error'))
    <div>{{session('error')}}</div>
    @endif
    @if($errors->any())
    @foreach($errors->all() as $error)
    {{$error}}
    @endforeach
    @endif
    <form action="{{route('add_user')}}" method="post">
      @csrf
      <input placeholder="名前" name="name">
      <input placeholder="メール" name="email">
      <input placeholder="パスワード" name="password">
      <select name="admin_bool">
        <option value="0">一般ユーザー</option>
        <option value="1">管理者</option>
      </select>
      <input type="submit" value="追加する">
    </form>
    @foreach($all_users as $user)
    <div style="display:flex;">
      <form method="post" action="{{route('edit_user')}}" style="display:flex;">
        @csrf
        <input value="{{$user->id}}" name="id" hidden>
        <input value="{{$user->name}}" name="name">
        <input type="submit" value="編集する">
      </form>
      <form method="post" action="{{route('delete_user')}}">
        @csrf
        <input hidden name="id" value="{{$user->id}}">
        <input type="submit" value="削除する">
      </form>
    </div>
    @endforeach
    <form action="{{route('add_content')}}" method="post">
      @csrf
      コンテンツ名<input name="name">
      色<input name="color">
      <input type="submit" value="コンテンツ追加する">
    </form>
    @foreach($all_contents as $content)
    <div style="display:flex;">
      <form action="{{route('edit_content')}}" method="post">
        @csrf
        <input name="id" value="{{$content->id}}" hidden>
        <input name="name" value="{{$content->content}}">
        <input name="color" value="{{$content->color_code}}">
        <input type="submit" value="コンテンツを編集する">
      </form>
      <form action="{{route('delete_content')}}" method="post">
        @csrf
        <input name="id" value="{{$content->id}}" hidden>
        <input type="submit" value="コンテンツを削除する">
      </form>
    </div>
    @endforeach
    <form action="{{route('add_language')}}" method="post">
      @csrf
      言語名<input name="name">
      色<input name="color">
      <input type="submit" value="言語追加する">
    </form>
    @foreach($all_languages as $language)
    <div style="display:flex;">
      <form action="{{route('edit_language')}}" method="post">
        @csrf
        <input name="id" value="{{$language->id}}" hidden>
        <input name="name" value="{{$language->language}}">
        <input name="color" value="{{$language->color_code}}">
        <input type="submit" value="言語を編集する">
      </form>
      <form action="{{route('delete_language')}}" method="post">
        @csrf
        <input name="id" value="{{$language->id}}" hidden>
        <input type="submit" value="言語を削除する">
      </form>
    </div>
    @endforeach
  </div>
</body>

</html>