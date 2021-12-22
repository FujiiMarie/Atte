<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>@yield('title')</title>
  <style>
    body {
      font-size: 16px;
      margin: 5px;
    }
    h1 {
      font-size: 30px;
      margin: 10px;
    }
    .content {
      margin: 10px;
    }
  </style>

</head>

<body>

  <header>
    <h1>
      <a href="{{--Atteを押したときにホームへ飛ぶリンクをここに入れる--}}">@yield('title')</a>
    </h1>
    <nav>
      <ul>
        <li><a href="">ホーム</a></li>
        <li><a href="">日付一覧</a></li>
        <li><a href="">ログアウト</a></li>
      </ul>
    </nav>
  </header>

  <div class="content">
    @yield('content')
  </div>

  <footer>
    <small>Atte, inc.</small>
  </footer>
</body>
</html>