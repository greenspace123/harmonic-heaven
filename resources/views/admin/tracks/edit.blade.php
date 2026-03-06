@extends('layouts.admin')
@section('title', 'Редактирование треков')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="custom-card p-5">
            <h4 class="mb-4 fw-bold">Редактирование трека</h4>
            
            <form method="POST" action="{{ route('admin.tracks.update', $track->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
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

                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <label class="form-label">Обложка</label>
                        <div class="mb-3">
                            @if($track->cover_path)
                                <img src="{{ Storage::url($track->cover_path) }}" alt="Обложка" class="img-fluid rounded mb-3" style="max-height: 150px;">
                            @endif
                        </div>
                        <input type="file" class="form-control" name="cover" accept="image/*">
                        <small class="text-muted">Оставьте пустым, чтобы не менять</small>
                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <label>Название</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $track->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Исполнитель</label>
                            <input type="text" class="form-control" name="artist" value="{{ old('artist', $track->artist) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Жанр</label>
                            <select class="form-select" name="genre_id">
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ $track->genre_id == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Год</label>
                            <input type="number" class="form-control" name="year" value="{{ old('year', $track->year ?? date('Y')) }}">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="is_premium" id="is_premium" {{ $track->is_premium ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_premium">Премиум контент</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="is_downloadable" id="is_downloadable" {{ $track->is_downloadable ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_downloadable">Доступен для скачивания</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label>Аудио файл</label>
                        <div class="mb-2">
                            <small class="text-muted">Текущий файл: {{ basename($track->file_path) }}</small>
                        </div>
                        <input type="file" class="form-control" name="audio" accept=".mp3,.wav">
                        <small class="text-muted">Оставьте пустым, чтобы не менять</small>
                    </div>

                    <div class="col-12 mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        <a href="{{ route('admin.tracks.index') }}" class="btn btn-outline-secondary">Отмена</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
