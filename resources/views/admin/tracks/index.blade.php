@extends('layouts.admin')
@section('content')
<div class="mb-4 d-flex justify-content-between">
    <h3>Библиотека</h3>
    <a href="{{ route('admin.tracks.create') }}" class="btn btn-primary">Добавить трек</a>
</div>
<div class="custom-card p-0">
    <table class="table table-custom mb-0">
        <thead><tr><th>#</th><th>Название</th><th>Действия</th></tr></thead>
        <tbody>
            @foreach($tracks as $track)
            <tr>
                <td><img src="{{ Storage::url($track->cover_path) }}" width="40" class="rounded"></td>
                <td>
                    <div class="fw-bold">{{ $track->title }}</div>
                    <div class="small text-muted">{{ $track->artist }}</div>
                    <div class="small text-muted">{{ $track->genre->name ?? 'Без жанра' }}</div>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.tracks.edit', $track->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <form action="{{ route('admin.tracks.destroy', $track->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm text-danger" onclick="return confirm('Удалить этот трек?')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $tracks->links() }}
@endsection