<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'is_admin'];

    public function favorites() {
        return $this->belongsToMany(Track::class, 'track_user')->withTimestamps();
    }
    
    // Добавляем связь с подписками
    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }
    
    // Получение активной подписки
    public function activeSubscription() {
        return $this->subscriptions()->where('status', 'active')->first();
    }
    
    // Получение активного плана
    public function subscriptionPlan() {
        $subscription = $this->activeSubscription();
        return $subscription ? $subscription->plan : 'free';
    }

    /**
     * Плейлисты пользователя
     */
    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }
}
