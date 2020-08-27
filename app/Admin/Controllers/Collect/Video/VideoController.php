<?php

namespace App\Admin\Controllers\Collect\Video;

use App\Models\Collect\Video\Video;
use App\Models\Tag\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VideoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '视频管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Video());
        //默认排序
        $grid->model()->latest('id');

        $grid->column('id', __('Id'));

        $grid->column('video_title', __('标题'))->editable();

        $grid->column('video_img', __('封面图片'))->image('', 50, 50);

        $grid->column('video_link', __('视频地址'));

        $grid->column('video_click', __('点击量'))->editable();

        $grid->column('video_show', __('是否显示'))->switch(config('system.switch'));

        $grid->column('video_recommend', __('是否推荐'))->switch(config('system.recommend'));

        $grid->column('video_sort', __('admin.sort'))->sortable()->editable();

        $grid->column('created_at', __('添加时间'))->sortable();

        //搜索条件
        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('video_title', '标题名称');
            //标签
            $filter->where(function ($query) {
                $tag_ids = $this->input;
                $query->whereHas('tags', function ($query) use ($tag_ids) {
                    $query->where('tag_name', 'like', '%' . $tag_ids . '%');
                });
            }, '标签', 'tag_id');

            $filter->equal('video_show', '显示or隐藏')->radio(config('system.filter_radio'));

            $filter->equal('video_recommend', '是否推荐')->radio(config('system.filter_radio'));
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
        $show = new Show(video::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new video());

        $form->text('video_title', __('标题'))->attribute('autocomplete', 'off')->required()->rules('required|max:100');

        $form->checkbox('tags','标签')->options(Tag::all()->where('tag_status', Tag::STATUS_TRUE)->pluck('tag_name', 'id'));

        $form->textarea('video_describe', __('视频简介'));

        $form->image('video_img','封面图')->required()->removable();

        $form->chunk_file('video_link', '所属视频')->attribute('accept', 'video/*')->rules('required');

        $form->number('video_click', __('点击量'))->rules('required')->default(0);

        $form->switch('video_show', __('是否显示'))->states(config('system.show'))->default(1);

        $form->switch('video_recommend', __('是否推荐'))->states(config('system.recommend'))->default(1);

        $form->number('video_sort', __('admin.sort'))->rules('required')->default(100);

        //保存后回调
        $form->saved(function (Form $form) {

        });
        return $form;
    }
}
