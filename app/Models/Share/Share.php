<?php

namespace App\Models\Share;

use App\Models\BaseModel;
use App\Models\Tag\Tag;
use App\Models\Tag\TagGable;
use App\Models\Website\Nav;
use Illuminate\Support\Str;

class Share extends BaseModel
{
    const TABLE = 'sw_share';

    protected $table = self::TABLE;

    protected $fillable = [
        'nav_id',
        'share_title',
        'share_icon',
        'share_src',
        'share_intro',
        'share_describe',
        'share_link',
        'share_sort',
        'share_show',
    ];

    protected $casts = [
        'share_show' => 'boolean',
    ];

   
    /**
     * 导航栏
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nav_type()
    {
        return $this->belongsTo(Nav::class, 'nav_id', 'id')->where('nav_type', Nav::NAV_TYPE_CARD);
    }

    /**
     * 单图修改器
     * @param $share_src
     * @author tnbcc <tniub.cc@gmail.com>
     */
    public function setShareSrcAttribute($share_src)
    {
        if (isset($share_src)) {
            if (!Str::startsWith($share_src, ['http://', 'https://'])) {
                $share_src = 'http://' . env('QINIU_DOMAIN') . '/' . $share_src;
            }
        } else {
            $share_src = env('APP_URL') . '/uploads/default_article.jpeg';
        }
        $this->attributes['share_src'] = $share_src;
    }
}
