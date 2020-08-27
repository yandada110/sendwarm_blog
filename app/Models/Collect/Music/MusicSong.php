<?php

namespace App\Models\Collect\Music;

use Illuminate\Database\Eloquent\Model;

class MusicSong extends Model
{
    const TABLE = 'sw_music_song';

    protected $table = self::TABLE;

    protected $fillable = [
        'song_id',
        'music_id',
    ];
}
