<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/27
 * Time: 16:09
 */

namespace App\Repositories\Web\Collect;

use App\Models\Collect\Music\SongList;
use App\Models\Tag\TagGable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MusicRepository
{
    /**
     * 歌单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $music_result = SongList::query()
            ->where('song_list_show', true)
            ->latest('song_list_sort')
            ->latest('id');

        //标签是否存在
        if ($tag_id = $request->input('tag_id', '')) {
            $music_result->whereHas('tags', function ($query) use ($tag_id) {
                $query->where('id', $tag_id);
            });
        }

        $music_result = $music_result ->paginate(8);
        //查询所有标签
        $tags = TagGable::query()
            ->select(DB::raw('count(tag_id) as counts,tag_id'))
            ->whereHasMorph('tag_gable', SongList::class)
            ->groupBy('tag_id')
            ->latest('counts')
            ->with(['tags' => function ($query) {
                $query->select(DB::raw('id, tag_name, FLOOR(0 + (RAND() * 6)) as tag_color, tag_click'));
            }])
            ->get();
        //加入标签颜色
        $tag_color = config('constant.tag_color');

        return view('web.collect.music.index',compact('tag_color', 'music_result', 'tags'));
    }

    /**
     * 音乐列表
     * @param SongList $song
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function musicList(SongList $song)
    {
        //不存在返回上一页
        if (empty($song) || !$song->song_list_show) return redirect(url()->previous());
        //点击量自增
        $song::query()->increment('song_list_click');
        //获取徽章颜色
        $tag_color = config('constant.tag_color');
        //获取音乐列表
        $music_list = $song->music;
        //获取标签
        $tags = $song->tags;
        return view('web.collect.music.music_list', compact('song', 'tag_color', 'music_list', 'tags'));
    }
}
