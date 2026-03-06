<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    /**
     * Список плейлистов пользователя
     */
    public function index()
    {
        $playlists = auth()->user()->playlists()->latest()->get();
        return view('playlists.index', compact('playlists'));
    }

    /**
     * Показать отдельный плейлист
     */
    public function show(Playlist $playlist)
    {
        // Проверка доступа
        if ($playlist->user_id !== auth()->id() && !$playlist->is_public) {
            abort(403, 'Доступ запрещён');
        }

        $playlist->load('tracks.genre');
        return view('playlists.show', compact('playlist'));
    }

    /**
     * Форма создания плейлиста
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Сохранение нового плейлиста
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|image|max:5000'
        ]);

        $data = $request->only(['name', 'description']);
        $data['user_id'] = auth()->id();
        $data['is_public'] = $request->has('is_public');

        // Загрузка обложки
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('playlist_covers', 'public');
        }

        $playlist = Playlist::create($data);

        return redirect()->route('playlists.show', $playlist)->with('success', 'Плейлист создан!');
    }

    /**
     * Форма редактирования плейлиста
     */
    public function edit(Playlist $playlist)
    {
        // Проверка прав
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        return view('playlists.edit', compact('playlist'));
    }

    /**
     * Обновление плейлиста
     */
    public function update(Request $request, Playlist $playlist)
    {
        // Проверка прав
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|image|max:5000'
        ]);

        $data = $request->only(['name', 'description']);
        $data['is_public'] = $request->has('is_public');

        // Загрузка новой обложки
        if ($request->hasFile('cover_image')) {
            if ($playlist->cover_image) {
                Storage::disk('public')->delete($playlist->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('playlist_covers', 'public');
        }

        $playlist->update($data);

        return redirect()->route('playlists.show', $playlist)->with('success', 'Плейлист обновлён!');
    }

    /**
     * Удаление плейлиста
     */
    public function destroy(Playlist $playlist)
    {
        // Проверка прав
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        if ($playlist->cover_image) {
            Storage::disk('public')->delete($playlist->cover_image);
        }

        $playlist->delete();

        return redirect()->route('playlists.index')->with('success', 'Плейлист удалён');
    }

    /**
     * Добавить трек в плейлист
     */
    public function addTrack(Request $request, Playlist $playlist)
    {
        // Проверка прав
        if ($playlist->user_id !== auth()->id()) {
            return response()->json(['error' => 'Доступ запрещён'], 403);
        }

        $request->validate([
            'track_id' => 'required|exists:tracks,id'
        ]);

        $track = Track::findOrFail($request->track_id);
        $playlist->addTrack($track);

        return response()->json(['success' => true, 'message' => 'Трек добавлен в плейлист']);
    }

    /**
     * Удалить трек из плейлиста
     */
    public function removeTrack(Playlist $playlist, Track $track)
    {
        // Проверка прав
        if ($playlist->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        $playlist->removeTrack($track);

        return back()->with('success', 'Трек удалён из плейлиста');
    }

    /**
     * Получить список плейлистов для модального окна
     */
    public function getUserPlaylists()
    {
        $playlists = auth()->user()->playlists()->get();
        return response()->json($playlists);
    }
}
