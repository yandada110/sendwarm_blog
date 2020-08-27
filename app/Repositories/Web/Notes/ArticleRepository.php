<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/9
 * Time: 17:41
 */

namespace App\Repositories\Web\Notes;

use App\Models\Notes\Article;
use App\Models\Tag\TagGable;
use App\Models\Website\Nav;
use App\Models\Website\Notice;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleRepository
{
    /**
     * 我的博文
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        //获取文章列表
        $list = Article::query()->where('article_status', Article::STATUS_ONE)->where('article_show', true);
        //标题是否存在
        if ($search_title = $request->input('search_title')) {
            $list->where('article_title', 'like', '%' . $search_title . '%');
        }
        //导航栏是否存在
        if ($nav_id = $request->route('nav_id', '')) {
            $list->where('nav_id', $nav_id);
        }
        //标签是否存在
        if ($tag_id = $request->input('tag_id', '')) {
            $list->whereHas('tags', function ($query) use ($tag_id) {
                $query->where('id', $tag_id);
            });
        }
        //查询所有标签
        $tags = TagGable::query()
            ->select(DB::raw('count(tag_id) as counts,tag_id'))
            ->whereHasMorph('tag_gable', Article::class, function (Builder $query) use ($search_title, $nav_id) {
                if ($search_title) $query->where('article_title', 'like', '%' . $search_title . '%');
                if ($nav_id) $query->where('nav_id', $nav_id);
            })
            ->groupBy('tag_id')
            ->latest('counts')
            ->with(['tags' => function ($query) {
                $query->select(DB::raw('id, tag_name, FLOOR(0 + (RAND() * 6)) as tag_color, tag_click'));
            }])
            ->get();
        //加入标签颜色
        $tag_color = config('constant.tag_color');
        //点击量
        $article_click = $list->sum('article_click');
        //获取热门
        $hot_article = $list->latest('article_sort')->take(3)->get();
        //所有查询
        $article_list = $list->latest('article_sort')->latest('id')->paginate(6);
        //按钮颜色
        $button_color = config('constant.button_color');
        shuffle($button_color);
        //背景颜色
        $background_color = config('constant.background_color');
        shuffle($background_color);
        //公告
        $notice_list = Notice::getNavList(Nav::NAV_TYPE_ARTICLE);
        //星期数组
        $week_list = config('constant.week_list');

        return view('web.notes.article.article', compact('article_list', 'background_color', 'hot_article', 'button_color', 'notice_list', 'week_list', 'search_title', 'tags', 'tag_color', 'article_click'));

    }

    /**
     * 文章详情
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Article $article)
    {
        //标签
        $tags = $article->tags;
        //获取上一篇文章
        $articleID['previous'] = $article::query()
                ->where('article_show', true)
                ->where('article_status', Article::STATUS_ONE)
                ->where('nav_id', $article->nav_id)
                ->where('id', '<', $article->id)
                ->max('id') ?? 0;
        //获取下一篇文章
        $articleID['next'] = $article::query()
                ->where('article_show', true)
                ->where('article_status', Article::STATUS_ONE)
                ->where('nav_id', $article->nav_id)
                ->where('id', '>', $article->id)
                ->min('id') ?? 0;;
        //获取本篇文章url
        $article_url = url()->current();
        //获取本篇文章所属留言
//        $article_message = BlogMessage::where('foreign_id', $a_id)->orderBy('id', 'desc')->paginate(6);
        //获取留言的背景色
//        $bg_arr = define_background();
        //获取徽章颜色
        $badge_arr = ['primary', 'info', 'success', 'warning', 'danger', 'default'];
        //点击量自增
        $article::query()->increment('article_click');

        return view('web.notes.article.article_detail', compact('article', 'article_url', 'badge_arr', 'articleID', 'tags'));
    }
}
