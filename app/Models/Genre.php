<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model {
    protected $fillable = ['name', 'slug'];
    public function tracks() { return $this->hasMany(Track::class); }
}
