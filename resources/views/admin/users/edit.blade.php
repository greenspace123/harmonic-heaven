@extends('layouts.admin')

@section('title', 'Редактирование пользователя')
@section('header_title', 'Редактирование пользователя')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="custom-card p-5">
            <h4 class="mb-4 fw-bold">Информация о пользователе</h4>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e) <li>{{$e}}</li> @endforeach</ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <label class="form-label">Аватар</label>
                        <div class="mb-3">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="Аватар" class="rounded-circle mb-3" 
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 120px; height: 120px; font-size: 3rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <input type="file" class="form-control" name="avatar" accept="image/*">
                        <small class="text-muted">Оставьте пустым, чтобы не менять</small>
                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Новый пароль</label>
                            <input type="password" class="form-control" name="password" placeholder="Оставьте пустым, чтобы не менять">
                            <small class="text-muted">Минимум 8 символов</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Подтверждение пароля</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Роль</label>
                            <input type="text" class="form-control" value="{{ $user->is_admin ? 'Администратор' : 'Пользователь' }}" disabled>
                            <small class="text-muted">Роль нельзя изменить через эту форму</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Дата регистрации</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('d.m.Y H:i') }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Отмена</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
