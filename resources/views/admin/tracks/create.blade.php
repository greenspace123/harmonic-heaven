@extends('layouts.admin')
@section('title', 'Создание треков')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="custom-card p-5">
            <form method="POST" action="{{ route('admin.tracks.store') }}" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->all() as $e) <li>{{$e}}</li> @endforeach</ul>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <label class="form-label">Обложка</label>
                        <input type="file" class="form-control" name="cover" accept="image/*">
                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <label>Название</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label>Исполнитель</label>
                            <input type="text" class="form-control" name="artist" required>
                        </div>
                        <div class="mb-3">
                            <label>Жанр</label>
                            <select class="form-select" name="genre_id">
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <label>Аудио файл</label>
                        <input type="file" class="form-control" name="audio" accept=".mp3,.wav" required>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
                                    <input type="checkbox" class="form-check-input" name="is_premium" id="is_premium" value="1">
                                    <label class="form-check-label fw-bold" for="is_premium">
                                        <i class="bi bi-star-fill text-warning me-1"></i>Премиум контент
                                    </label>
                                    <small class="text-muted d-block mt-1">Доступно только для подписчиков</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded">
                                    <input type="checkbox" class="form-check-input" name="is_downloadable" id="is_downloadable" value="1">
                                    <label class="form-check-label fw-bold" for="is_downloadable">
                                        <i class="bi bi-download text-success me-1"></i>Доступен для скачивания
                                    </label>
                                    <small class="text-muted d-block mt-1">Могут скачивать пользователи с подпиской</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Опубликовать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection