<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TrackController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PlaylistController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    $latestTracks = \App\Models\Track::latest()->take(6)->get();
    return view('home', compact('latestTracks'));
})->name('home');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::post('/tracks/{track}/favorite', [CatalogController::class, 'toggleFavorite'])->name('tracks.favorite');
Route::get('/tracks/{track}/download', [TrackController::class, 'download'])->name('tracks.download')->middleware('auth');

Route::view('/subscription', 'subscription')->name('subscription');
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe')->middleware('auth');
Route::post('/cancel-subscription', [SubscriptionController::class, 'cancel'])->name('cancel-subscription')->middleware('auth');
Route::post('/renew-subscription', [SubscriptionController::class, 'renew'])->name('renew-subscription')->middleware('auth');
Route::get('/subscription/history', [SubscriptionController::class, 'history'])->name('subscription.history')->middleware('auth');
Route::get('/api/subscription/status', [SubscriptionController::class, 'checkStatus'])->name('api.subscription.status')->middleware('auth');

Route::view('/help', 'help')->name('help');
Route::post('/support', [SupportController::class, 'send'])->name('support.send');

Route::get('/profile', function () {
    $user = auth()->user();
    $favorites = $user->favorites()->with('genre')->latest()->get();
    $subscription = $user->subscriptions()->where('status', 'active')->first();
    return view('profile', compact('user', 'favorites', 'subscription'));
})->middleware('auth')->name('profile');

// Маршруты для плейлистов
Route::middleware('auth')->group(function () {
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
    Route::post('/playlists/{playlist}/tracks', [PlaylistController::class, 'addTrack'])->name('playlists.add-track');
    Route::delete('/playlists/{playlist}/tracks/{track}', [PlaylistController::class, 'removeTrack'])->name('playlists.remove-track');
    Route::get('/api/user/playlists', [PlaylistController::class, 'getUserPlaylists'])->name('api.user.playlists');
});

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::resource('tracks', TrackController::class);

    // Маршруты для управления пользователями
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/feedbacks', function() {
        $feedbacks = \App\Models\Feedback::latest()->paginate(10);
        return view('admin.feedbacks.index', compact('feedbacks'));
    })->name('feedbacks.index');

    Route::get('/feedbacks/{feedback}', function(\App\Models\Feedback $feedback) {
        $feedback->status = 'read';
        $feedback->save();
        return view('admin.feedbacks.show', compact('feedback'));
    })->name('feedbacks.show');

    Route::delete('/feedbacks/{feedback}', function(\App\Models\Feedback $feedback) {
        $feedback->delete();
        return back()->with('success', 'Сообщение удалено');
    })->name('feedbacks.destroy');
});

// Резервный маршрут /home (перенаправляет на главную)
Route::get('/home', function() {
    return redirect()->route('home');
})->name('home.redirect');