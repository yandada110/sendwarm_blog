<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/9
 * Time: 17:41
 */

namespace App\Repositories\Web\Share;

use App\Models\Share\Share;
use Illuminate\Http\Request;

class ShareRepository
{

    public function list(Request $request)
    {
        //获取分享列表
        $list = Share::query()->where('share_show', true);

        //导航栏是否存在
        if ($nav_id = $request->route('nav_id', '')) {
            $list->where('nav_id', $nav_id);
        }
        //所有查询
        $share_list = $list->latest('share_sort')->latest('id')->paginate(8);
        //按钮颜色
        $button_color = config('constant.button_color');
        shuffle($button_color);
        //背景颜色
        $background_color = config('constant.background_color');
        shuffle($background_color);

        return view('web.share.share',compact('share_list','button_color','background_color'));

    }

}
