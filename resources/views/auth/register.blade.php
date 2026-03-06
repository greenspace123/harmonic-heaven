@extends('layouts.header')

@section('title', 'Регистрация')

@section('content')
<div class="container py-5 d-flex align-items-center" style="min-height: 80vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6">
            <div class="custom-card p-4 p-md-5 shadow-lg">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-1">Создать аккаунт</h3>
                    <p class="text-muted small">Присоединяйтесь к Harmonic Haven</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
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
                    <div class="mb-3">
                        <label for="name" class="form-label ms-3 small text-muted fw-bold">Ваше имя</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Как к вам обращаться?" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label ms-3 small text-muted fw-bold">Email адрес</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="email" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label ms-3 small text-muted fw-bold">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label ms-3 small text-muted fw-bold">Подтверждение</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class="mb-4 form-check ms-3">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label text-muted small" for="terms">
                            Я согласен с <a href="#" class="text-decoration-none" style="color: var(--color-accent);">Условиями использования</a>
                        </label>
                    </div>
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">Зарегистрироваться</button>
                    </div>
                    <div class="text-center">
                        <p class="text-muted small mb-0">Уже есть аккаунт? 
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: var(--color-secondary);">Войти</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection