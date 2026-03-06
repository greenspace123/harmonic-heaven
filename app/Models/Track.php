<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model {
    protected $fillable = ['title', 'artist', 'genre_id', 'year', 'cover_path', 'file_path', 'is_premium', 'is_downloadable'];
    public function genre() { return $this->belongsTo(Genre::class); }
    // Связь "Кто лайкнул этот трек"
    public function likedBy() { return $this->belongsToMany(User::class, 'track_user'); }
}
