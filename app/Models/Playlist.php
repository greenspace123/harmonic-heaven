<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'cover_image', 'is_public'];

    /**
     * Пользователь, которому принадлежит плейлист
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Треки в плейлисте
     */
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_tracks')
                    ->withPivot('order')
                    ->orderBy('playlist_tracks.order');
    }

    /**
     * Добавить трек в плейлист
     */
    public function addTrack(Track $track, $order = null)
    {
        if ($order === null) {
            $order = $this->tracks()->count();
        }
        
        $this->tracks()->syncWithoutDetaching([
            $track->id => ['order' => $order]
        ]);
    }

    /**
     * Удалить трек из плейлиста
     */
    public function removeTrack(Track $track)
    {
        $this->tracks()->detach($track->id);
    }

    /**
     * Количество треков в плейлисте
     */
    public function getTracksCountAttribute()
    {
        return $this->tracks()->count();
    }

    /**
     * Общая длительность плейлиста (примерно)
     */
    public function getDurationAttribute()
    {
        // Заглушка - в реальности нужно считать из треков
        return $this->tracks_count * 210; // среднее 3:30 на трек
    }
}
