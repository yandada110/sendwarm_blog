<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/27
 * Time: 16:09
 */

namespace App\Repositories\Web\Collect;

use App\Models\Collect\Video\Video;
use App\Models\Tag\TagGable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoRepository
{
    /**
     * 视频列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $video_result = Video::query()
            ->select('id', 'video_title', 'video_describe', 'video_img', 'video_click', 'updated_at')
            ->where('video_show', true)
            ->latest('video_sort')
            ->latest('id');

        //标签是否存在
        if ($tag_id = $request->input('tag_id', '')) {
            $video_result->whereHas('tags', function ($query) use ($tag_id) {
                $query->where('id', $tag_id);
            });
        }
        $recommended_video = $video_result->where('video_recommend', true)->limit(8)->get();

        $video_result = $video_result->paginate(8);

        //查询所有标签
        $tags = TagGable::query()
            ->select(DB::raw('count(tag_id) as counts,tag_id'))
            ->whereHasMorph('tag_gable', Video::class)
            ->groupBy('tag_id')
            ->latest('counts')
            ->with(['tags' => function ($query) {
                $query->select(DB::raw('id, tag_name, FLOOR(0 + (RAND() * 6)) as tag_color, tag_click'));
            }])
            ->get();
        //加入标签颜色
        $tag_color = config('constant.tag_color');

        return view('web.collect.video.index', compact('video_result', 'tag_color', 'tags', 'recommended_video'));
    }

    /**
     * 视频详情
     * @param Video $videos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function VideoDetail(Video $videos)
    {
        //不存在返回上一页
        if (empty($videos) || !$videos->video_show) return redirect(url()->previous());
        //点击量自增
        $videos::query()->increment('video_click');
        //加入标签颜色
        $tag_color = config('constant.tag_color');
        //获取标签
        $tags = $videos->tags;
        return view('web.collect.video.video_details', compact('videos', 'tag_color','tags'));
    }
}
