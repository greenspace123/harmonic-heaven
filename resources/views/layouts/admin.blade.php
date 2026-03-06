<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HH Admin  @yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbolinks@5.2.0/dist/turbolinks.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
<div class="admin-wrapper">
    <nav class="admin-sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-vinyl-fill me-2"></i>Admin Panel
        </div>
        <ul class="nav flex-column admin-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Обзор
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.tracks.*') ? 'active' : '' }}" href="{{ route('admin.tracks.index') }}">
                    <i class="bi bi-music-note-beamed"></i> Треки
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people-fill"></i> Пользователи
                </a>
            </li>
        </ul>
        <div class="mt-auto p-3 border-top border-secondary">
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm w-100 rounded-pill mb-2">
                <i class="bi bi-box-arrow-right me-1"></i> На сайт
            </a>
            <div class="small text-center text-white-50">v.1.0</div>
        </div>
    </nav>
    <main class="admin-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold text-dark">@yield('header_title', 'Панель управления')</h2>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                        <li><a class="dropdown-item" href="#">Профиль</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#">Выход</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    Turbolinks.start();
</script>
</body>
</html>