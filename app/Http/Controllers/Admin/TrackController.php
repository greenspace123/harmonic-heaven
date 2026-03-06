<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrackController extends Controller
{
    // Главная страница админки (список)
    public function index() {
        $tracks = Track::with('genre')->latest()->paginate(10);
        // Считаем статистику для шапки
        $stats = [
            'total_tracks' => Track::count(),
            'total_users' => \App\Models\User::count(),
        ];
        return view('admin.tracks.index', compact('tracks', 'stats'));
    }

    // Форма создания
    public function create() {
        $genres = Genre::all();
        return view('admin.tracks.create', compact('genres'));
    }

    // Сохранение трека (Самое важное!)
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'artist' => 'required',
            'genre_id' => 'required',
            'audio' => 'required|file|mimes:mp3,wav,ogg|max:30000', // макс 30МБ
            'cover' => 'nullable|image|max:5000'
        ]);

        $data = $request->only(['title', 'artist', 'genre_id', 'year']);
        $data['is_premium'] = $request->has('is_premium');
        $data['is_downloadable'] = $request->has('is_downloadable');

        // Сохраняем файл музыки
        if($request->hasFile('audio')) {
            $data['file_path'] = $request->file('audio')->store('music', 'public');
        }

        // Сохраняем обложку
        if($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        Track::create($data);

        return redirect()->route('admin.tracks.index')->with('success', 'Трек успешно загружен!');
    }

    // Удаление
    public function destroy(Track $track) {
        if($track->file_path) Storage::disk('public')->delete($track->file_path);
        if($track->cover_path) Storage::disk('public')->delete($track->cover_path);
        $track->delete();
        return back()->with('success', 'Трек удален');
    }

    // Форма редактирования
    public function edit(Track $track) {
        $genres = Genre::all();
        return view('admin.tracks.edit', compact('track', 'genres'));
    }

    // Обновление трека
    public function update(Request $request, Track $track) {
        $request->validate([
            'title' => 'required',
            'artist' => 'required',
            'genre_id' => 'required',
            'audio' => 'nullable|file|mimes:mp3,wav,ogg|max:30000',
            'cover' => 'nullable|image|max:5000'
        ]);

        $data = $request->only(['title', 'artist', 'genre_id', 'year']);
        $data['is_premium'] = $request->has('is_premium');
        $data['is_downloadable'] = $request->has('is_downloadable');

        // Загружаем новый файл музыки если есть
        if($request->hasFile('audio')) {
            // Удаляем старый файл
            if($track->file_path) Storage::disk('public')->delete($track->file_path);
            $data['file_path'] = $request->file('audio')->store('music', 'public');
        }

        // Загружаем новую обложку если есть
        if($request->hasFile('cover')) {
            // Удаляем старую обложку
            if($track->cover_path) Storage::disk('public')->delete($track->cover_path);
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $track->update($data);

        return redirect()->route('admin.tracks.index')->with('success', 'Трек успешно обновлён!');
    }

    /**
     * Скачать трек (для пользователей с подпиской)
     */
    public function download(Track $track)
    {
        $user = auth()->user();
        
        // Проверка: трек должен быть доступен для скачивания
        if (!$track->is_downloadable) {
            return back()->with('error', 'Этот трек недоступен для скачивания');
        }
        
        // Проверка подписки
        $hasSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->whereIn('plan', ['pro', 'collector'])
            ->exists();
        
        if (!$hasSubscription && !$user->is_admin) {
            return back()->with('error', 'Скачивание доступно только для пользователей с подпиской Pro или Collector');
        }
        
        // Скачивание файла
        if ($track->file_path && Storage::disk('public')->exists($track->file_path)) {
            return Storage::disk('public')->download($track->file_path, $track->title . ' - ' . $track->artist . '.mp3');
        }
        
        return back()->with('error', 'Файл не найден');
    }
}
