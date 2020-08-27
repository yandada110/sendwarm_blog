<?php

namespace App\Models\Notes;

use App\Models\Tag\Tag;
use App\Models\Tag\TagGable;
use App\Models\Website\Nav;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    const TABLE = 'sw_article';

    protected $table = self::TABLE;

    const STATUS_ZERO = 0;
    const STATUS_ONE = 1;
    const STATUS_TWO = 2;
    const STATUS_THREE = 3;

    public static $statusMap = [
        self::STATUS_ZERO => '待审核',
        self::STATUS_ONE => '审核通过',
        self::STATUS_TWO => '不通过',
        self::STATUS_THREE => '已删除',
    ];

    protected $fillable = [
        'nav_id',
        'article_title',
        'article_image',
        'article_describe',
        'article_content',
        'article_status',
        'article_click',
        'article_show',
        'article_sort',
    ];

    protected $casts = [
        'article_show' => 'boolean',
    ];

    /**
     * 文章关联标签
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, TagGable::TABLE);
    }

    /**
     * 导航栏
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nav_type()
    {
        return $this->belongsTo(Nav::class, 'nav_id', 'id')->where('nav_type', Nav::NAV_TYPE_ARTICLE);
    }

    /**
     * 单图修改器
     * @param $article_image
     * @author tnbcc <tniub.cc@gmail.com>
     */
    public function setArticleImageAttribute($article_image)
    {
        if (isset($article_image)) {
            if (!Str::startsWith($article_image, ['http://', 'https://'])) {
                $article_image = 'http://' . env('QINIU_DOMAIN') . '/' . $article_image;
            }
        } else {
            $article_image = env('APP_URL') . '/uploads/default_article.jpeg';
        }
        $this->attributes['article_image'] = $article_image;
    }
}
