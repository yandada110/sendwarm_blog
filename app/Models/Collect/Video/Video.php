<?php

namespace App\Models\Collect\Video;

use App\Models\BaseModel;
use App\Models\Tag\Tag;
use App\Models\Tag\TagGable;
use Illuminate\Support\Str;

class Video extends BaseModel
{
    const TABLE = 'sw_video';

    protected $table = self::TABLE;

    protected $fillable = [
        'video_title',
        'video_describe',
        'video_img',
        'video_link',
        'video_click',
        'video_sort',
        'video_recommend',
        'video_show',
    ];

    protected $casts = [
        'video_recommend' => 'boolean',
        'video_show' => 'boolean',
    ];

    /**
     * 获取标签
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, TagGable::TABLE);
    }

    /**
     * 单图修改器
     * @param $video_img
     * @author tnbcc <tniub.cc@gmail.com>
     */
    public function setVideoImgAttribute($video_img)
    {
        if (isset($video_img)) {
            if (!Str::startsWith($video_img, ['http://', 'https://'])) {
                $video_img = 'http://' . env('QINIU_DOMAIN') . '/' . $video_img;
            }
        } else {
            $video_img = env('APP_URL') . '/uploads/default_article.jpeg';
        }
        $this->attributes['video_img'] = $video_img;
    }

    /**
     * 视频修改
     * @param $video_link
     * @author tnbcc <tniub.cc@gmail.com>
     */
    public function setVideoLinkAttribute($video_link)
    {
        if (!Str::startsWith($video_link, ['http://', 'https://'])) {
            $video_link = 'http://' . env('QINIU_DOMAIN') . '/' . $video_link;
        }
        $this->attributes['video_link'] = $video_link;
//        if (!empty($video_link)) {
//            $video_link = json_decode($video_link, true);
//            $data = [];
//            foreach ($video_link as $value) {
//
//            }
//            $this->attributes['video_link'] = $data;
//        }
    }
}
