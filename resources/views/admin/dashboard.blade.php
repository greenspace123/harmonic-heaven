@extends('layouts.admin')

@section('title', 'Панель администратора')
@section('header_title', 'Обзор статистики')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem;">Всего треков</h6>
                <h2 class="mb-0 fw-bold" style="color: var(--color-header);">{{ number_format($stats['total_tracks']) }}</h2>
            </div>
            <div class="stat-icon bg-light text-primary" style="color: var(--color-accent) !important;">
                <i class="bi bi-music-note-list"></i>
            </div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem;">Пользователи</h6>
                <h2 class="mb-0 fw-bold" style="color: var(--color-header);">{{ number_format($stats['total_users']) }}</h2>
            </div>
            <div class="stat-icon bg-light text-success">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem;">Подписки (Active)</h6>
                <h2 class="mb-0 fw-bold" style="color: var(--color-header);">{{ number_format($stats['active_subscriptions']) }}</h2>
            </div>
            <div class="stat-icon bg-light" style="color: var(--color-secondary);">
                <i class="bi bi-credit-card-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="custom-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold">Последние загрузки</h5>
                <a href="{{ route('admin.tracks.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Все треки</a>
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Трек</th>
                            <th>Исполнитель</th>
                            <th>Жанр</th>
                            <th>Дата</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestTracks as $track)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $track->cover_path ? Storage::url($track->cover_path) : 'https://placehold.co/30' }}" 
                                         class="rounded" width="30" height="30" style="object-fit: cover;">
                                    <span class="fw-bold">{{ $track->title }}</span>
                                </div>
                            </td>
                            <td>{{ $track->artist }}</td>
                            <td><span class="badge badge-genre rounded-pill py-1">{{ $track->genre->name ?? 'Без жанра' }}</span></td>
                            <td class="text-muted">{{ $track->created_at->format('d М Y') }}</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill">Активен</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Треков пока нет</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection