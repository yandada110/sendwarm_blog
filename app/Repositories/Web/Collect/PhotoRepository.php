<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/27
 * Time: 16:09
 */

namespace App\Repositories\Web\Collect;

use App\Models\Collect\Photo\Photo;
use App\Models\Tag\TagGable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhotoRepository
{
    /**
     * 歌单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $photo_result = Photo::query()
            ->select('id', 'photo_title', 'photo_describe', 'photo_img', 'photo_click', 'updated_at')
            ->where('photo_show', true)
            ->latest('photo_sort')
            ->latest('id');

        //标签是否存在
        if ($tag_id = $request->input('tag_id', '')) {
            $photo_result->whereHas('tags', function ($query) use ($tag_id) {
                $query->where('id', $tag_id);
            });
        }

        $photo_result = $photo_result ->paginate(8);
        //查询所有标签
        $tags = TagGable::query()
            ->select(DB::raw('count(tag_id) as counts,tag_id'))
            ->whereHasMorph('tag_gable', Photo::class)
            ->groupBy('tag_id')
            ->latest('counts')
            ->with(['tags' => function ($query) {
                $query->select(DB::raw('id, tag_name, FLOOR(0 + (RAND() * 6)) as tag_color, tag_click'));
            }])
            ->get();
        //加入标签颜色
        $tag_color = config('constant.tag_color');

        return view('web.collect.photo.index', compact('photo_result', 'tag_color', 'tags'));
    }

    /**
     * 音乐列表
     * @param Photo $photos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function photoList(Photo $photos)
    {
        //不存在返回上一页
        if (empty($photos) || !$photos->photo_show) return redirect(url()->previous());
        //点击量自增
        $photos::query()->increment('photo_click');

        return view('web.collect.photo.photo_details', compact('photos'));
    }
}
