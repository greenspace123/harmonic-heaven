@extends('layouts.header')

@section('title', 'Мои плейлисты')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Мои плейлисты</h2>
        <a href="{{ route('playlists.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-2"></i>Создать плейлист
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($playlists->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($playlists as $playlist)
                <div class="col">
                    <div class="custom-card h-100 overflow-hidden">
                        <div class="position-relative" style="height: 200px; background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-header) 100%);">
                            @if($playlist->cover_image)
                                <img src="{{ Storage::url($playlist->cover_image) }}" alt="{{ $playlist->name }}" 
                                     class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute bottom-0 start-0 w-100 h-100" 
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);"></div>
                            @endif
                            <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                <h5 class="fw-bold mb-1 text-truncate">{{ $playlist->name }}</h5>
                                <small class="opacity-75">
                                    <i class="bi bi-music-note-beamed me-1"></i>{{ $playlist->tracks_count }} треков
                                </small>
                            </div>
                            @if(!$playlist->is_public)
                                <span class="position-absolute top-0 end-0 badge bg-secondary m-2">
                                    <i class="bi bi-lock-fill"></i> Приватный
                                </span>
                            @endif
                        </div>
                        <div class="card-body p-3">
                            @if($playlist->description)
                                <p class="text-muted small mb-3 text-truncate">{{ $playlist->description }}</p>
                            @endif
                            <div class="d-flex gap-2">
                                <a href="{{ route('playlists.show', $playlist) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="bi bi-play-fill me-1"></i>Слушать
                                </a>
                                <a href="{{ route('playlists.edit', $playlist) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-music-note-list display-1 text-muted opacity-25"></i>
            </div>
            <h4 class="mb-3">У вас пока нет плейлистов</h4>
            <p class="text-muted mb-4">Создайте свой первый плейлист и добавьте в него любимые треки</p>
            <a href="{{ route('playlists.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i>Создать плейлист
            </a>
        </div>
    @endif
</div>

@endsection
