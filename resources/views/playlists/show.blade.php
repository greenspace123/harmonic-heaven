@extends('layouts.header')

@section('title', $playlist->name)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('playlists.index') }}">Плейлисты</a></li>
            <li class="breadcrumb-item active">{{ $playlist->name }}</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Информация о плейлисте -->
        <div class="col-lg-4 mb-4">
            <div class="custom-card p-4 text-center">
                <div class="mb-4 position-relative d-inline-block">
                    @if($playlist->cover_image)
                        <img src="{{ Storage::url($playlist->cover_image) }}" alt="{{ $playlist->name }}" 
                             class="rounded shadow" style="width: 250px; height: 250px; object-fit: cover;">
                    @else
                        <div class="rounded d-flex align-items-center justify-content-center mx-auto shadow" 
                             style="width: 250px; height: 250px; background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-header) 100%);">
                            <i class="bi bi-music-note-list display-1 text-white"></i>
                        </div>
                    @endif
                </div>

                <h2 class="fw-bold mb-2">{{ $playlist->name }}</h2>
                
                @if($playlist->description)
                    <p class="text-muted mb-3">{{ $playlist->description }}</p>
                @endif

                <div class="d-flex justify-content-center gap-3 mb-3 text-muted small">
                    <span><i class="bi bi-music-note-beamed me-1"></i>{{ $playlist->tracks->count() }} треков</span>
                    <span><i class="bi bi-clock me-1"></i>{{ floor($playlist->duration / 60) }} мин</span>
                </div>

                @if($playlist->is_public)
                    <span class="badge bg-success mb-3"><i class="bi bi-globe me-1"></i>Публичный</span>
                @else
                    <span class="badge bg-secondary mb-3"><i class="bi bi-lock-fill me-1"></i>Приватный</span>
                @endif

                <div class="d-grid gap-2">
                    <button class="btn btn-primary rounded-pill play-playlist-btn" data-playlist-id="{{ $playlist->id }}">
                        <i class="bi bi-play-fill me-2"></i>Слушать всё
                    </button>
                    @if($playlist->user_id === auth()->id())
                        <a href="{{ route('playlists.edit', $playlist) }}" class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-pencil-fill me-2"></i>Редактировать
                        </a>
                        <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" 
                              onsubmit="return confirm('Удалить этот плейлист?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill w-100">
                                <i class="bi bi-trash-fill me-2"></i>Удалить
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Список треков -->
        <div class="col-lg-8">
            <div class="custom-card">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Треки</h5>
                    <span class="badge bg-primary rounded-pill">{{ $playlist->tracks->count() }}</span>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($playlist->tracks as $track)
                        <div class="list-group-item p-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                <img src="{{ $track->cover_path ? Storage::url($track->cover_path) : 'https://placehold.co/50' }}"
                                     class="rounded" width="50" height="50" style="object-fit: cover">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">{{ $track->title }}</h6>
                                    <small class="text-muted">{{ $track->artist }} • {{ $track->genre->name ?? 'Без жанра' }}</small>
                                </div>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <button class="btn btn-light rounded-circle text-primary play-track-btn"
                                        data-id="{{ $track->id }}"
                                        data-url="{{ Storage::url($track->file_path) }}"
                                        data-title="{{ $track->title }}"
                                        data-artist="{{ $track->artist }}"
                                        data-cover="{{ $track->cover_path ? Storage::url($track->cover_path) : '' }}">
                                    <i class="bi bi-play-fill fs-5"></i>
                                </button>
                                @if($playlist->user_id === auth()->id())
                                    <form action="{{ route('playlists.remove-track', [$playlist, $track]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-danger" title="Удалить из плейлиста">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-muted">
                            <i class="bi bi-music-note-beamed display-4 mb-3 d-block opacity-25"></i>
                            В этом плейлисте пока нет треков
                            <br>
                            <a href="{{ route('catalog') }}" class="btn btn-link mt-2">Перейти в каталог</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
