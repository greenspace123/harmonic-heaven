@extends('layouts.header')
@section('title', 'Каталог')
@section('content')
<div class="container px-3 px-md-4 px-lg-5">
    <!-- Заголовок и поиск -->
    <div class="search-header pt-4 pt-md-5 pb-3 pb-md-4 mb-4">
        <h1 class="h3 mb-4 fw-bold">Каталог треков</h1>
        <form method="GET" action="{{ route('catalog') }}" class="row g-2 g-md-3 align-items-center">
            <div class="col-12 col-lg-9">
                <div class="position-relative">
                    <input type="text" name="search" value="{{ request('search', '') }}" 
                           class="form-control rounded-pill ps-5 pe-4 shadow-sm w-100 py-3" 
                           placeholder="Поиск по названию, артисту..." autocomplete="off">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-4 text-muted"></i>
                    @if(request('search'))
                        <button type="button" onclick="clearSearch()" 
                                class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-3 text-muted">
                            <i class="bi bi-x-lg small"></i>
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-10 col-lg-3 mt-2 mt-lg-0">
                <button type="submit" class="btn btn-primary rounded-pill w-90 py-3 shadow fw-semibold">
                    <i class="bi bi-search me-2"></i>Найти
                </button>
            </div>
        </form>
    </div>

    <!-- Фильтры по жанрам -->
    <div class="filters-section mb-5">
        <div class="d-flex flex-wrap gap-2 gap-md-3" id="genresContainer">
            <a href="{{ route('catalog') }}" 
               class="btn rounded-pill px-4 py-2 {{ !request('genre') ? 'btn-primary text-white shadow-sm' : 'btn-outline-primary border-2' }}">
                Все
            </a>
            @foreach($genres as $g)
                <a href="{{ route('catalog', ['genre' => $g->slug, 'search' => request('search')]) }}" 
                   class="genre-btn btn rounded-pill px-4 py-2 {{ request('genre') == $g->slug ? 'btn-primary text-white shadow-sm' : 'btn-outline-primary border-2' }}">
                   {{ $g->name }}
                </a>
            @endforeach
        </div>
    </div>

    @if($tracks->count() > 0)
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-muted small">
            Найдено: <span class="fw-bold">{{ $tracks->total() }}</span> треков
        </div>
        <div class="dropdown">
            
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Сначала новые</a></li>
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}">По популярности</a></li>
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'title']) }}">По названию</a></li>
            </ul>
        </div>
    </div>
    @endif

    <div class="tracks-grid mb-5">
        @if($tracks->count() > 0)
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 g-md-4">
            @foreach($tracks as $track)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition-all">
                    <div class="position-relative overflow-hidden rounded-top" style="height: 180px;">
                        <img src="{{ $track->cover_path ? Storage::url($track->cover_path) : asset('images/default-cover.jpg') }}" 
                             class="w-100 h-100 object-fit-cover transition-scale" 
                             alt="{{ $track->title }}"
                             loading="lazy">
                        <div class="position-absolute top-0 end-0 p-3 d-flex gap-2">
                            @auth
                                @if(auth()->user()->subscriptions()->where('status', 'active')->whereIn('plan', ['pro', 'collector'])->exists() || auth()->user()->is_admin)
                                    @if($track->is_downloadable)
                                        <a href="{{ route('tracks.download', $track->id) }}" class="btn btn-download btn-sm btn-light rounded-circle p-2 shadow-sm text-success" title="Скачать">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    @endif
                                @endif
                            @endauth
                            <button class="btn btn-add-to-playlist btn-sm btn-light rounded-circle p-2 shadow-sm text-muted"
                                    data-id="{{ $track->id }}"
                                    data-title="{{ $track->title }}"
                                    title="Добавить в плейлист">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                            <button class="btn btn-like btn-sm btn-light rounded-circle p-2 shadow-sm {{ auth()->check() && auth()->user()->favorites->contains($track->id) ? 'text-danger' : 'text-muted' }}"
                                    data-id="{{ $track->id }}">
                                <i class="bi {{ auth()->check() && auth()->user()->favorites->contains($track->id) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                            </button>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark">
                            <button class="btn btn-play btn-primary btn-sm rounded-pill px-3 py-1 shadow-sm play-track-btn" 
                                    data-id="{{ $track->id }}"
                                    data-url="{{ Storage::url($track->file_path) }}"
                                    data-title="{{ $track->title }}"
                                    data-artist="{{ $track->artist }}"
                                    data-cover="{{ $track->cover_path ? Storage::url($track->cover_path) : asset('images/default-cover.jpg') }}">
                                <i class="bi bi-play-fill me-1"></i>Слушать
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-light text-dark rounded-pill px-2 py-1 small">{{ $track->genre->name }}</span>
                            <small class="text-muted">{{ $track->duration ?? '3:45' }}</small>
                        </div>
                        <h6 class="card-title fw-bold mb-1 text-truncate">{{ $track->title }}</h6>
                        <p class="card-text text-muted small mb-0">{{ $track->artist }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else

        <div class="text-center py-5 my-5">
            <div class="mb-4">
                <i class="bi bi-music-note-beamed display-1 text-muted opacity-25"></i>
            </div>
            <h3 class="h4 mb-3">Треки не найдены</h3>
            <p class="text-muted mb-4 col-md-6 mx-auto">
                Попробуйте изменить поисковый запрос или выберите другой жанр
            </p>
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('catalog') }}" class="btn btn-outline-primary rounded-pill px-4">
                    Показать все треки
                </a>
            </div>
        </div>
        @endif
    </div>

    @if($tracks->hasPages())
    <div class="py-4">
        {{ $tracks->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.clearSearch = function() {
        const url = new URL(window.location.href);
        url.searchParams.delete('search');
        window.location.href = url.toString();
    }

    window.clearAllFilters = function() {
        window.location.href = "{{ route('catalog') }}";
    }

    document.addEventListener('click', function(e) {
        const likeBtn = e.target.closest('.btn-like');
        if (likeBtn) {
            e.preventDefault();
            const trackId = likeBtn.dataset.id;
            
            @guest
                window.location.href = "{{ route('login') }}";
                return;
            @endguest

            fetch(`/tracks/${trackId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const icon = likeBtn.querySelector('i');
                    if (data.liked) {
                        icon.className = 'bi bi-heart-fill';
                        likeBtn.classList.remove('text-muted');
                        likeBtn.classList.add('text-danger');
                    } else {
                        icon.className = 'bi bi-heart';
                        likeBtn.classList.remove('text-danger');
                        likeBtn.classList.add('text-muted');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    const genres = document.querySelectorAll('.genre-btn');
    const container = document.getElementById('genresContainer');
    
    if (genres.length > 8) {
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'btn btn-outline-primary rounded-pill px-4 py-2';
        toggleBtn.innerHTML = 'Ещё <i class="bi bi-chevron-down ms-1"></i>';
        
        for (let i = 8; i < genres.length; i++) {
            genres[i].classList.add('d-none');
        }
        
        container.appendChild(toggleBtn);
        
        let isExpanded = false;
        toggleBtn.addEventListener('click', function() {
            isExpanded = !isExpanded;
            
            for (let i = 8; i < genres.length; i++) {
                genres[i].classList.toggle('d-none');
            }
            
            toggleBtn.innerHTML = isExpanded 
                ? 'Свернуть <i class="bi bi-chevron-up ms-1"></i>' 
                : 'Ещё <i class="bi bi-chevron-down ms-1"></i>';
        });
    }

    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') !== '#') {
                e.preventDefault();
                const url = this.getAttribute('href');
                window.scrollTo({ top: 0, behavior: 'smooth' });
                setTimeout(() => window.location.href = url, 300);
            }
        });
    });
});
</script>

<!-- Модальное окно добавления в плейлист -->
@if(auth()->check())
<div class="modal fade" id="addToPlaylistModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить в плейлист</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="playlist-list" class="list-group">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Загрузка...</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('playlists.create') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                        <i class="bi bi-plus-circle me-1"></i>Создать новый плейлист
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
// Обработчик для кнопки "Добавить в плейлист"
@if(auth()->check())
document.addEventListener('click', function(e) {
    const addBtn = e.target.closest('.btn-add-to-playlist');
    if (addBtn) {
        e.preventDefault();
        const trackId = addBtn.dataset.id;
        const trackTitle = addBtn.dataset.title;
        
        const modal = new bootstrap.Modal(document.getElementById('addToPlaylistModal'));
        document.querySelector('.modal-title').textContent = 'Добавить "' + trackTitle + '" в плейлист';
        modal.show();
        
        // Загрузка плейлистов
        fetch('{{ route("api.user.playlists") }}')
            .then(response => response.json())
            .then(playlists => {
                const container = document.getElementById('playlist-list');
                if (playlists.length === 0) {
                    container.innerHTML = '<div class="text-center py-3 text-muted">У вас пока нет плейлистов<br><small>Создайте новый плейлист</small></div>';
                } else {
                    container.innerHTML = playlists.map(p => 
                        '<button class="list-group-item list-group-item-action d-flex align-items-center justify-content-between" onclick="addToPlaylist(' + p.id + ', ' + trackId + ')">' +
                            '<div class="d-flex align-items-center gap-2">' +
                                '<i class="bi bi-music-note-list text-primary"></i>' +
                                '<span>' + p.name + '</span>' +
                            '</div>' +
                            '<small class="text-muted">' + p.tracks_count + ' треков</small>' +
                        '</button>'
                    ).join('');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('playlist-list').innerHTML = '<div class="text-center py-3 text-danger">Ошибка загрузки плейлистов</div>';
            });
    }
});

function addToPlaylist(playlistId, trackId) {
    fetch('/playlists/' + playlistId + '/tracks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ track_id: trackId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('addToPlaylistModal')).hide();
            alert('Трек добавлен в плейлист!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ошибка при добавлении трека');
    });
}
@endif
</script>

@endsection