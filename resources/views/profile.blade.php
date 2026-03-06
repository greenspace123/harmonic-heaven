@extends('layouts.header')

@section('title', 'Профиль')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Боковая панель -->
        <div class="col-md-4 mb-4">
            <div class="custom-card p-4 text-center h-100">
                <div style="width: 100px; height: 100px; background-color: var(--color-accent); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;" class="mb-3">
                    <!-- Первая буква имени -->
                    {{ substr($user->name, 0, 1) }}
                </div>

                <!-- Динамическое имя и почта -->
                <h4 class="fw-bold">{{ $user->name }}</h4>
                <p class="text-muted mb-1">{{ $user->email }}</p>

                @if($user->is_admin)
                    <span class="badge bg-danger mb-3">Администратор</span>
                @else
                    <span class="badge bg-secondary mb-3">Пользователь</span>
                @endif

                <div class="d-grid gap-2 mt-4">
                    <a class="btn btn-outline-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">
                        Выйти
                    </a>
                    <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <!-- Основная область -->
        <div class="col-md-8">
            <!-- Секция Плейлисты -->
            <div class="custom-card mb-4">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Мои плейлисты</h5>
                    <a href="{{ route('playlists.create') }}" class="btn btn-sm btn-primary rounded-pill">
                        <i class="bi bi-plus-circle me-1"></i>Создать
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @php
                            $userPlaylists = $user->playlists()->latest()->take(5)->get();
                        @endphp
                        @forelse($userPlaylists as $playlist)
                            <a href="{{ route('playlists.show', $playlist) }}" class="list-group-item list-group-item-action p-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    @if($playlist->cover_image)
                                        <img src="{{ Storage::url($playlist->cover_image) }}" 
                                             class="rounded" width="50" height="50" style="object-fit: cover">
                                    @else
                                        <div class="rounded d-flex align-items-center justify-content-center bg-primary text-white" 
                                             style="width: 50px; height: 50px;">
                                            <i class="bi bi-music-note"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $playlist->name }}</h6>
                                        <small class="text-muted">{{ $playlist->tracks_count }} треков</small>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                        @empty
                            <div class="p-4 text-center text-muted">
                                <i class="bi bi-music-note-list display-6 mb-2 d-block opacity-25"></i>
                                У вас пока нет плейлистов
                                <br>
                                <a href="{{ route('playlists.create') }}" class="btn btn-sm btn-primary mt-2">Создать первый</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Секция Избранное -->
            <div class="custom-card mb-4">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Моя коллекция ❤️</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($favorites as $track)
                            <div class="list-group-item p-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Обложка -->
                                    <img src="{{ $track->cover_path ? Storage::url($track->cover_path) : 'https://placehold.co/50' }}"
                                         class="rounded" width="50" height="50" style="object-fit: cover">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $track->title }}</h6>
                                        <small class="text-muted">{{ $track->artist }}</small>
                                    </div>
                                </div>

                                <!-- Кнопка Play -->
                                <button class="btn btn-light rounded-circle text-primary play-track-btn"
                                        data-id="{{ $track->id }}"
                                        data-url="{{ Storage::url($track->file_path) }}"
                                        data-title="{{ $track->title }}"
                                        data-artist="{{ $track->artist }}"
                                        data-cover="{{ $track->cover_path ? Storage::url($track->cover_path) : '' }}">
                                    <i class="bi bi-play-fill fs-5"></i>
                                </button>
                            </div>
                        @empty
                            <div class="p-5 text-center text-muted">
                                <i class="bi bi-music-note-beamed display-4 mb-3 d-block opacity-25"></i>
                                Вы еще не добавили ни одного трека в избранное.
                                <br>
                                <a href="{{ route('catalog') }}" class="btn btn-link mt-2">Перейти в каталог</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
