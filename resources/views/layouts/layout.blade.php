<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Laravel Layout Example')</title>
  <link rel="stylesheet" href="/css/app.css">
</head>

<body>
  <header class="header">
    <h2><a href="/">My Laravel App</a></h2>
    <nav>
      <ul>
        <li><a href="/movies">ムービー</a></li>
        <li><a href="/sheets">座席</a></li>
      </ul>
    </nav>
  </header>

  <main>
    @yield('content')
  </main>

  <footer>
    <p>&copy; 2024 My Laravel App</p>
  </footer>
</body>

</html>