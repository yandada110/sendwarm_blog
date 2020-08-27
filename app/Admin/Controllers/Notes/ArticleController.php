<?php

namespace App\Admin\Controllers\Notes;

use App\Models\Notes\Article;
use App\Models\Tag\TagGable;
use App\Models\Website\Nav;
use App\Models\Tag\Tag;
use App\Services\Tag\TagService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());
        //默认排序
        $grid->model()->latest('id');

        $grid->column('id', __('Id'));

        $grid->nav_type()->nav_title(__('导航栏'));

        $grid->column('tags', __('标签'))->display(function ($tags) {
            $tags = array_map(function ($tags) {
                return "<span class='label label-success'>{$tags['tag_name']}</span>";
            }, $tags);
            return join('&nbsp;', $tags);
        });

        $grid->column('article_title', __('标题'))->editable();

        $grid->column('article_image', __('图片'))->image('', 50, 50);


        $grid->column('article_status', __('admin.status'))->using(Article::$statusMap);

        $grid->column('article_show', __('是否显示'))->switch(config('system.switch'));

        $grid->column('article_sort', __('admin.sort'))->sortable()->editable();

        $grid->column('created_at', __('添加时间'))->sortable();

        //搜索条件
        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('article_title', '标题名称');

            $navList = Nav::query()->where('nav_type', Nav::NAV_TYPE_ARTICLE)->pluck('nav_title', 'id')->toArray();
            array_unshift($navList, '全部');
            $filter->equal('nav_id', '导航栏位置')->radio($navList);

            //标签
            $filter->where(function ($query) {
                $tag_ids = $this->input;
                $query->whereHas('tags', function ($query) use ($tag_ids) {
                    $query->where('tag_name', 'like', '%' . $tag_ids . '%');
                });
            }, '标签', 'tag_id');

            $filter->equal('article_show', '显示or隐藏')->radio(config('system.filter_radio'));

            $filter->equal('article_status', '显示or隐藏')->radio(Article::$statusMap);

        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());

        $form->select('nav_id', __('导航栏'))->options(
            Nav::query()->where('nav_type', Nav::NAV_TYPE_ARTICLE)->pluck('nav_title', 'id')
        )->required();

        $form->text('article_title', __('文章标题'))->attribute('autocomplete', 'off')->required()->rules('required|max:100');

        $form->checkbox('tags')->options(Tag::all()->where('tag_status', Tag::STATUS_TRUE)->pluck('tag_name', 'id'));

        $form->textarea('article_describe', __('文章简介'));

        $form->editormd('article_content', __('文章内容'))->required()->rules('required');

        $form->image('article_image')->required()->removable();

        $form->radio('article_status', __('admin.status'))->options(Article::$statusMap)->default(Article::STATUS_ONE)->required();

        $form->switch('article_show', __('是否显示'))->states(config('system.show'))->default(1);

        $form->number('article_sort', __('admin.sort'))->rules('required')->default(100);

        $form->number('article_click', __('点击量'))->rules('required')->default(0);

        return $form;
    }
}
