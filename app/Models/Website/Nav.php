<?php

namespace App\Models\Website;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    use ModelTree, AdminBuilder;

    const TABLE = 'sw_nav';

    protected $table = self::TABLE;

    const NAV_TYPE_TOP = 0;
    const NAV_TYPE_ARTICLE = 1;
    const NAV_TYPE_PHOTO = 2;
    const NAV_TYPE_MUSIC = 3;
    const NAV_TYPE_VIDEO = 4;
    const NAV_TYPE_CARD = 5;

    public static $navTypeMap = [
        self::NAV_TYPE_TOP => '顶级分类',
        self::NAV_TYPE_ARTICLE => '文章',
        self::NAV_TYPE_PHOTO => '照片',
        self::NAV_TYPE_MUSIC => '音乐',
        self::NAV_TYPE_VIDEO => '视频',
        self::NAV_TYPE_CARD => '卡片',
    ];

    protected $fillable = [
        'nav_title',
        'nav_type',
        'nav_open',
        'nav_sort',
        'nav_pid',
        'nav_route',
        'is_nav',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('nav_pid');
        $this->setOrderColumn('nav_sort');
        $this->setTitleColumn('nav_title');
    }

    public function getTree()
    {
        $get_data = self::query()->orderBy('id', 'asc')->get()->toArray();
        return modelTree($get_data);
    }
}
