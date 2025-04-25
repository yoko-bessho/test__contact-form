<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-app.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <div class="header-left"></div>
                <div class="header-logo">
                    FashionablyLate
                </div>
                <nav class= "header-nav">
                    <ul>
                      <li>
                          @yield('header-nav')
                      </li>
                    </ul>
                </nav>
              </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>