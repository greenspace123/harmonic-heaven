<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Feedback;

class DashboardController extends Controller
{
    /**
     * Показать панель администратора со статистикой
     */
    public function index()
    {
        // Считаем статистику
        $stats = [
            'total_tracks' => Track::count(),
            'total_users' => User::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'pending_feedbacks' => Feedback::where('status', 'pending')->count(),
        ];

        // Последние треки
        $latestTracks = Track::with('genre')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestTracks'));
    }
}
