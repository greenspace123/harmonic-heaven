@extends('layouts.header')

@section('title', 'Редактирование плейлиста')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('playlists.index') }}">Плейлисты</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('playlists.show', $playlist) }}">{{ $playlist->name }}</a></li>
                    <li class="breadcrumb-item active">Редактирование</li>
                </ol>
            </nav>

            <div class="custom-card p-5">
                <h4 class="mb-4 fw-bold">Редактирование плейлиста</h4>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('playlists.update', $playlist) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold">Обложка плейлиста</label>
                        <div class="mb-3">
                            @if($playlist->cover_image)
                                <div id="cover-preview" class="mb-3">
                                    <img src="{{ Storage::url($playlist->cover_image) }}" alt="Обложка" 
                                         class="rounded" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            @else
                                <div id="cover-preview" class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 150px; height: 150px; font-size: 3rem;">
                                    <i class="bi bi-music-note"></i>
                                </div>
                            @endif
                        </div>
                        <input type="file" class="form-control" name="cover_image" accept="image/*" id="cover-input">
                        <small class="text-muted">Оставьте пустым, чтобы не менять</small>
                        
                        @if($playlist->cover_image)
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCover()">
                                    <i class="bi bi-trash-fill me-1"></i>Удалить обложку
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Название</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $playlist->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Описание</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description', $playlist->description) }}</textarea>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" name="is_public" id="is_public" value="1" {{ $playlist->is_public ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_public">
                            Публичный плейлист
                        </label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-circle me-2"></i>Сохранить
                        </button>
                        <a href="{{ route('playlists.show', $playlist) }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-x-circle me-2"></i>Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('cover-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('cover-preview');
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Предпросмотр" class="rounded" style="width: 150px; height: 150px; object-fit: cover;">';
        };
        reader.readAsDataURL(file);
    }
});

function removeCover() {
    if (confirm('Удалить обложку плейлиста?')) {
        // Здесь можно добавить AJAX запрос для удаления обложки
        document.getElementById('cover-preview').innerHTML = '<div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px; font-size: 3rem;"><i class="bi bi-music-note"></i></div>';
    }
}
</script>

@endsection
