<?php

namespace App\Models\Collect\Photo;

use App\Models\BaseModel;
use App\Models\Tag\Tag;
use App\Models\Tag\TagGable;
use Illuminate\Support\Str;

class Photo extends BaseModel
{
    const TABLE = 'sw_photo';

    protected $table = self::TABLE;

    protected $fillable = [
        'photo_title',
        'photo_describe',
        'photo_img',
        'photo_click',
        'photo_show',
        'photo_sort',
        'photo_json',
    ];

    protected $casts = [
        'photo_show' => 'boolean',
        'photo_json' => 'json',
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
     * @param $photo_img
     * @author tnbcc <tniub.cc@gmail.com>
     */
    public function setPhotoImgAttribute($photo_img)
    {
        if (isset($photo_img)) {
            if (!Str::startsWith($photo_img, ['http://', 'https://'])) {
                $photo_img = 'http://' . env('QINIU_DOMAIN') . '/' . $photo_img;
            }
        } else {
            $photo_img = env('APP_URL') . '/uploads/default_article.jpeg';
        }
        $this->attributes['photo_img'] = $photo_img;
    }

    /**
     * 多图修改
     * @param $photo_json
     */
    public function setPhotoJsonAttribute($photo_json)
    {
        $images = [];
        foreach ($photo_json as $value) {
            if (!Str::startsWith($value, ['http://', 'https://'])) {
                $images[] = 'http://' . env('QINIU_DOMAIN') . '/' . $value;
            } else {
                $images[] = $value;
            }
        }
        if (!empty($images)) {
            $this->attributes['photo_json'] = json_encode($images);
        }else{
            $this->attributes['photo_json'] = '';
        }
    }
}
