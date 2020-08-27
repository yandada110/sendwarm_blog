<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    const TABLE = 'sw_notice';

    protected $table = self::TABLE;

    const NOTICE_SHOW = true;
    const NOTICE_HIDE = false;

    public static $statusMap = [
        self::NOTICE_SHOW => '显示',
        self::NOTICE_HIDE => '隐藏',
    ];

    protected $fillable = [
        'nav_id',
        'notice_title',
        'notice_content',
        'notice_sort',
        'notice_show',
    ];

    /**
     * 导航栏
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nav_type()
    {
        return $this->belongsTo(Nav::class, 'nav_id', 'id')->where('nav_type', Nav::NAV_TYPE_TOP);
    }

    /**
     * 获取公告列表
     * @param $nav_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getNavList($nav_id)
    {
        return self::query()
            ->select('id', 'notice_title', 'notice_content')
            ->where('nav_id', $nav_id)
            ->where('notice_show', Notice::NOTICE_SHOW)
            ->get();
    }

}
