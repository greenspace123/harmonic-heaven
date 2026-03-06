@extends('layouts.header')

@section('title', 'Подписка')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold">Инвестируйте в качество</h2>
        <p class="lead text-muted">Выберите план, который соответствует вашей страсти к музыке</p>
        
        @auth
            <a href="{{ route('subscription.history') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="bi bi-clock-history me-1"></i>История подписок
            </a>
        @endauth

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="row row-cols-1 row-cols-lg-3 align-items-center g-4">
        <!-- Бесплатный -->
        <div class="col">
            <div class="custom-card h-100 p-4">
                <div class="card-body">
                    <h4 class="mb-3">Новичок</h4>
                    <h1 class="display-4 fw-bold mb-4">0₽</h1>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Доступ к каталогу</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Стандартное качество (MP3)</li>
                        <li class="mb-2 text-muted"><i class="bi bi-dash me-2"></i>Реклама между треками</li>
                        <li class="mb-2 text-muted"><i class="bi bi-dash me-2"></i>Офлайн режим</li>
                    </ul>
                    @if(Auth::check() && Auth::user()->subscriptions()->where('status', 'active')->exists())
                        @if(Auth::user()->subscriptions()->where('plan', 'free')->where('status', 'active')->exists())
                            <button class="btn btn-outline-secondary w-100 rounded-pill" disabled>Ваш текущий план</button>
                        @else
                            <form method="POST" action="{{ route('cancel-subscription') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">Отменить подписку</button>
                            </form>
                        @endif
                    @else
                        <button class="btn btn-outline-secondary w-100 rounded-pill" disabled>Текущий план</button>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Про (Акцент) -->
        <div class="col">
            <div class="custom-card h-100 p-5 border border-2 border-primary position-relative" style="border-color: var(--color-secondary) !important; background: linear-gradient(to bottom right, #fff, #fdfbfd);">
                <div class="position-absolute top-0 start-50 translate-middle-x">
                    <span class="badge bg-secondary rounded-pill px-3 py-2 text-uppercase" style="background-color: var(--color-secondary) !important;">Рекомендуем</span>
                </div>
                <div class="card-body text-center">
                    <h4 class="mb-3" style="color: var(--color-secondary);">Меломан</h4>
                    <h1 class="display-3 fw-bold mb-4">299₽</h1>
                    <ul class="list-unstyled mb-4 text-start mx-auto" style="max-width: 250px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Без рекламы</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Hi-Fi качество (FLAC)</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Офлайн режим</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Фоновое воспроизведение</li>
                    </ul>
                    @if(Auth::check())
                        @if(Auth::user()->subscriptions()->where('plan', 'pro')->where('status', 'active')->exists())
                            <button class="btn btn-lavender w-100 rounded-pill btn-lg shadow" disabled>Активная подписка</button>
                        @else
                            <form method="POST" action="{{ route('subscribe') }}">
                                @csrf
                                <input type="hidden" name="plan" value="pro">
                                <button type="submit" class="btn btn-lavender w-100 rounded-pill btn-lg shadow">Оформить подписку</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-lavender w-100 rounded-pill btn-lg shadow">Войти для подписки</a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Люкс -->
        <div class="col">
            <div class="custom-card h-100 p-4">
                <div class="card-body">
                    <h4 class="mb-3">Коллекционер</h4>
                    <h1 class="display-4 fw-bold mb-4">599₽</h1>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Все функции Меломана</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Виниловые оцифровки</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Семейный доступ (5 чел.)</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Приоритетная поддержка</li>
                    </ul>
                    @if(Auth::check())
                        @if(Auth::user()->subscriptions()->where('plan', 'collector')->where('status', 'active')->exists())
                            <button class="btn btn-primary w-100 rounded-pill" disabled>Активная подписка</button>
                        @else
                            <form method="POST" action="{{ route('subscribe') }}">
                                @csrf
                                <input type="hidden" name="plan" value="collector">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill">Подписаться</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 rounded-pill">Войти для подписки</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection