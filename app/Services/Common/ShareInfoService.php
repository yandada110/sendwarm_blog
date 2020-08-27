<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/28
 * Time: 18:09
 */

namespace App\Services\Common;


use App\Models\Collect\Music\Music;
use App\Models\Website\Nav;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ShareInfoService extends BaseService
{
    public function webInfo()
    {
        //共享配置信息
        View::share('configs', DB::table('admin_config')->pluck('value', 'name'));
        //共享导航栏列表
        $top_data = Nav::query()
            ->where('nav_open', '=', 1)
            ->orderBy('nav_sort', 'asc')
            ->get();
        View::share('nav_list', sortMenu($top_data));
        //共享音乐列表数据
        $music_data = Music::query()
            ->select('music_name as title', 'music_describe as author', 'music_img as pic', 'music_url as url')
            ->where('music_play', 1)
            ->orderBy('music_sort', 'desc')
            ->get()
            ->toArray();
        View::share('my_music', json_encode($music_data));
    }
}
