<?php

namespace App\Models\Tag;

use App\Models\BaseModel;
use App\Models\Notes\Article;

class Tag extends BaseModel
{
    const TABLE = 'sw_tag';

    protected $table = self::TABLE;

    const STATUS_FALSE = false;
    const STATUS_TRUE = true;

    public static $statusMap = [
        self::STATUS_FALSE => '开启',
        self::STATUS_TRUE => '关闭',
    ];

    protected $fillable = [
        'tag_name',
        'tag_status',
        'tag_click',
        'tag_sort',
    ];

    protected $casts = [
        'tag_status' => 'boolean',
    ];

    /**
     * 获取被打上此标签的所有文章
     */
    public function article()
    {
        return $this->morphedByMany(Article::class, 'tag_gable');
    }
}
