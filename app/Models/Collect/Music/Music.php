<?php

namespace App\Models\Collect\Music;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Music extends Model
{
    const TABLE = 'sw_music';

    protected $table = self::TABLE;

    protected $fillable = [
        'music_name',
        'music_describe',
        'music_img',
        'music_url',
        'article_click',
        'music_show',
        'music_play',
        'music_sort',
    ];

    protected $casts = [
        'music_show' => 'boolean',
        'music_play' => 'boolean',
    ];

    /**
     * 关联歌单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function song()
    {
        return $this->belongsToMany(SongList::class, MusicSong::TABLE, 'music_id', 'song_id');
    }

    /**
     * 单图修改器
     * @param $music_img
     * @author tnbcc <tniub.cc@gmail.com>
     */
    public function setMusicImgAttribute($music_img)
    {
        if (isset($music_img)) {
            if (!Str::startsWith($music_img, ['http://', 'https://'])) {
                $music_img = 'http://' . env('QINIU_DOMAIN') . '/' . $music_img;
            }
        } else {
            $music_img = env('APP_URL') . '/uploads/default_article.jpeg';
        }
        $this->attributes['music_img'] = $music_img;
    }

    /**
     * 音乐修改器
     * @param $music_url
     * @author tnbcc <tniub.cc@gmail.com>
     */
    public function setMusicUrlAttribute($music_url)
    {
        if (isset($music_url)) {
            if (!Str::startsWith($music_url, ['http://', 'https://'])) {
                $music_url = 'http://' . env('QINIU_DOMAIN') . '/' . $music_url;
            }
        } else {
            $music_url = env('APP_URL') . '/uploads/default_article.jpeg';
        }
        $this->attributes['music_url'] = $music_url;
    }
}
