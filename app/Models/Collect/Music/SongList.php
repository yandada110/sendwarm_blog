<?php

namespace App\Models\Collect\Music;

use App\Models\BaseModel;
use App\Models\Tag\Tag;
use App\Models\Tag\TagGable;
use Illuminate\Support\Str;

class SongList extends BaseModel
{
    const TABLE = 'sw_song_list';

    protected $table = self::TABLE;

    protected $fillable = [
        'song_list_title',
        'song_list_describe',
        'song_list_img',
        'song_list_click',
        'song_list_show',
        'song_list_sort',
    ];

    protected $casts = [
        'song_list_show' => 'boolean',
    ];

    /**
     * 关联音乐
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function music()
    {
        return $this->belongsToMany(Music::class, MusicSong::TABLE, 'song_id', 'music_id')->latest('music_sort')->latest('article_click');
    }

    /**
     * 获取标签
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, TagGable::TABLE);
    }

    /**
     * 单图修改器
     * @param $song_list_img
     * @author tnbcc <tniub.cc@gmail.com>
     */
    public function setSongListImgAttribute($song_list_img)
    {
        if (isset($song_list_img)) {
            if (!Str::startsWith($song_list_img, ['http://', 'https://'])) {
                $song_list_img = 'http://' . env('QINIU_DOMAIN') . '/' . $song_list_img;
            }
        } else {
            $song_list_img = env('APP_URL') . '/uploads/default_article.jpeg';
        }
        $this->attributes['song_list_img'] = $song_list_img;
    }
}
