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
            min-height: 100vh;
      position: relative;
    }
    a {
      text-decoration: none;
      color: inherit;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: white;
    }
    h1 {
      font-size: 30px;
      margin-left: 50px;
    }
    .header-nav-list {
      display: flex;
    }
    .header-nav-item {
      list-style: none;
      margin-right: 50px;
    }
    .contents {
      margin: 10px;
    }
    .footer {
      width: 100%;
      font-size: small;
      font-weight: bold;
      text-align: center;
      padding: 15px;
      background: white;
      position: absolute;
      bottom: 0;
    }
  </style>
</head>

<body>
  @yield('header')

  <div class="contents">
    @yield('content')
  </div>

  @yield('footer')
</body>
</html>