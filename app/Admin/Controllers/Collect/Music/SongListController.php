<?php

namespace App\Admin\Controllers\Collect\Music;

use App\Models\Collect\Music\SongList;
use App\Models\Tag\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SongListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '歌单管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SongList());
        //默认排序
        $grid->model()->latest('id');

        $grid->column('id', __('Id'));

        $grid->column('tags', __('标签'))->display(function ($tags) {
            $tags = array_map(function ($tags) {
                return "<span class='label label-success'>{$tags['tag_name']}</span>";
            }, $tags);
            return join('&nbsp;', $tags);
        });

        $grid->column('song_list_title', __('标题'))->editable();

        $grid->column('song_list_img', __('封面图片'))->image('', 50, 50);

        $grid->column('song_list_click', __('点击量'))->editable();

        $grid->column('song_list_show', __('是否显示'))->switch(config('system.switch'));

        $grid->column('song_list_sort', __('admin.sort'))->sortable()->editable();

        $grid->column('created_at', __('添加时间'))->sortable();

        //搜索条件
        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('song_list_title', '标题名称');
            //标签
            $filter->where(function ($query) {
                $tag_ids = $this->input;
                $query->whereHas('tags', function ($query) use ($tag_ids) {
                    $query->where('tag_name', 'like', '%' . $tag_ids . '%');
                });
            }, '标签', 'tag_id');

            $filter->equal('song_list_show', '显示or隐藏')->radio(config('system.filter_radio'));
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
        $show = new Show(SongList::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SongList());

        $form->text('song_list_title', __('歌单标题'))->attribute('autocomplete', 'off')->required()->rules('required|max:100');

        $form->checkbox('tags','标签')->options(Tag::all()->where('tag_status', Tag::STATUS_TRUE)->pluck('tag_name', 'id'));

        $form->textarea('song_list_describe', __('歌单简介'));

        $form->image('song_list_img','封面图')->required()->removable();

        $form->number('song_list_click', __('点击量'))->rules('required')->default(0);

        $form->switch('song_list_show', __('是否显示'))->states(config('system.show'))->default(1);

        $form->number('song_list_sort', __('admin.sort'))->rules('required')->default(100);

        return $form;
    }
}
