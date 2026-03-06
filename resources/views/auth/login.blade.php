@extends('layouts.header')
@section('title', 'Вход')
@section('content')
<div class="container py-5 d-flex align-items-center" style="min-height: 80vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-5">
            <div class="custom-card p-4 p-md-5 shadow-lg">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-1">С возвращением</h3>
                    <p class="text-muted small">Продолжите свое музыкальное путешествие</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-4">
                        <label for="email" class="form-label ms-3 small text-muted fw-bold">Email адрес</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" placeholder="email" required autofocus>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label ms-3 small text-muted fw-bold">Пароль</label>
                        </div>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="mb-4 form-check ms-3">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember' ? 'checked' : '' )}}>
                        <label class="form-check-label text-muted small" for="remember">Запомнить меня</label>
                    </div>
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">Войти в аккаунт</button>
                    </div>
                    <div class="text-center">
                        <p class="text-muted small mb-0">Нет аккаунта? 
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: var(--color-secondary);">Зарегистрироваться</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection