<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harmonic Heaven - @yield('title')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon-180.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#00897B">
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbolinks@5.2.0/dist/turbolinks.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <i class="bi bi-vinyl-fill"></i> Harmonic Heaven
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-2">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">Каталог</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('playlists.*') ? 'active' : '' }}" href="{{ route('playlists.index') }}">Плейлисты</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('subscription') ? 'active' : '' }}" href="{{ route('subscription') }}">Подписка</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('help') ? 'active' : '' }}" href="{{ route('help') }}">Помощь</a>
    </li>
    @guest
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Вход</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Регистрация</a>
        </li>
    @else
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                <li><a class="dropdown-item" href="{{ route('profile') }}">Мой профиль</a></li>
                @if(Auth::user()->is_admin)
                    <li><a class="dropdown-item text-primary" href="{{ route('admin.dashboard') }}">Админ-панель</a></li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Выйти
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    @endguest
</ul>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1">
        @yield('content')
    </main>
    <footer>
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <h5>Harmonic Haven</h5>
                    <p>Ваше убежище в мире звуков. Мы сохраняем традиции аналогового звучания в цифровую эпоху.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <h5>Навигация</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('catalog') }}">Каталог</a></li>
                        <li class="mb-2"><a href="{{ route('subscription') }}">Тарифы</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#services">Услуги</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h5>Помощь</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('help') }}">FAQ</a></li>
                        <li class="mb-2"><a href="{{ route('help') }}">Поддержка</a></li>
                        <li class="mb-2"><a href="{{ route('help') }}">Лицензия</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 text-center">
                <p class="small mb-0">&copy; {{ date('Y') }} Harmonic Haven. Все права защищены.</p>
            </div>
        </div>
    </footer>
    @include('partials.player')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        Turbolinks.start();
        document.addEventListener('turbolinks:load', function() {
            const existingPlayer = document.getElementById('music-player');
            if (existingPlayer) {
                existingPlayer.setAttribute('data-turbolinks-permanent', 'true');
            }
            const audioElement = document.getElementById('audio-element');
            if (audioElement) {
                audioElement.setAttribute('data-turbolinks-permanent', 'true');
            }
        });
    </script>
    @yield('scripts')
</body>
</html>