@extends('layouts.admin')

@section('title', 'Пользователи')
@section('header_title', 'Управление пользователями')

@section('content')
<!-- Статистика -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="stat-card">
            <div>
                <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem;">Всего пользователей</h6>
                <h2 class="mb-0 fw-bold" style="color: var(--color-header);">{{ number_format($stats['total_users']) }}</h2>
            </div>
            <div class="stat-icon bg-light text-primary">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card">
            <div>
                <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem;">Пользователи</h6>
                <h2 class="mb-0 fw-bold" style="color: var(--color-header);">{{ number_format($stats['user_count']) }}</h2>
            </div>
            <div class="stat-icon bg-light text-success">
                <i class="bi bi-person-fill"></i>
            </div>
        </div>
    </div>
</div>

<!-- Поиск и фильтры -->
<div class="custom-card p-4 mb-4">
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
        <div class="col-md-8">
            <div class="position-relative">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control rounded-pill ps-4" placeholder="Поиск по имени или email...">
            </div>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary rounded-pill w-100">
                <i class="bi bi-search me-2"></i>Найти
            </button>
        </div>
    </form>
</div>

<!-- Уведомления -->
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

<!-- Таблица пользователей -->
<div class="custom-card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="50">ID</th>
                    <th>Пользователь</th>
                    <th>Email</th>
                    <th width="120">Роль</th>
                    <th width="150">Дата регистрации</th>
                    <th width="120">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted">{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                 style="width: 35px; height: 35px; flex-shrink: 0; font-size: 0.9rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="text-truncate" style="max-width: 200px;">
                                <div class="fw-bold text-truncate" title="{{ $user->name }}">{{ $user->name }}</div>
                                @if($user->avatar)
                                    <small class="text-success"><i class="bi bi-check-circle"></i> Аватар</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-truncate" style="max-width: 200px;" title="{{ $user->email }}">
                            {{ $user->email }}
                        </div>
                    </td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge bg-danger rounded-pill px-2 py-1 small">
                                Админ
                            </span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-2 py-1 small">
                                Польз.
                            </span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="btn btn-sm btn-outline-primary" title="Редактировать">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger"
                                        title="Удалить"
                                        onclick="return confirm('Удалить пользователя {{ $user->name }}?')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-inbox display-4 mb-3 d-block"></i>
                        Пользователи не найдены
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Пагинация -->
@if($users->hasPages())
    <div class="mt-4">
        {{ $users->appends(request()->query())->links() }}
    </div>
@endif
@endsection
