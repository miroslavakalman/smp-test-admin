<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    <nav>
    <img src="{{ asset('img/smp-logo.png') }}" alt="Логотип SMP Esports">
    <button class="object-choice">Дубровка <img src="img/arrow.svg" alt=""></button>
    <p><a href="https://google.com">Смены</a></p>
    <button class="end-session">Выйти</button>
    </nav>
    <main>
    @yield('content')
    </main>
</body>
</html>