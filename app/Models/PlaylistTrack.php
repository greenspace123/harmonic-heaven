<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistTrack extends Model
{
    use HasFactory;

    protected $fillable = ['playlist_id', 'track_id', 'order'];

    /**
     * Плейлист, к которому принадлежит связь
     */
    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    /**
     * Трек в плейлисте
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
