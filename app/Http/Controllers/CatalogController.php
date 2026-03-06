<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Genre;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request) {
        $query = Track::with('genre');

        // Поиск
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('artist', 'like', '%'.$request->search.'%');
        }

        // Фильтр по жанру
        if ($request->filled('genre')) {
            $query->whereHas('genre', function($q) use ($request) {
                $q->where('slug', $request->genre);
            });
        }

        $tracks = $query->latest()->paginate(12)->withQueryString();
        $genres = Genre::all();

        return view('catalog', compact('tracks', 'genres'));
    }

    public function toggleFavorite(Track $track) {
        if (!auth()->check()) abort(401);
        
        auth()->user()->favorites()->toggle($track->id);
        
        // Возвращаем JSON для JS
        return response()->json([
            'status' => 'success',
            'liked' => auth()->user()->favorites()->where('track_id', $track->id)->exists()
        ]);
    }
}
