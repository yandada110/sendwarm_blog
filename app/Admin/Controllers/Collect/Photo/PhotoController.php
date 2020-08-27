<?php

namespace App\Admin\Controllers\Collect\Photo;

use App\Models\Collect\Photo\Photo;
use App\Models\Tag\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PhotoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '相册管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Photo());
        //默认排序
        $grid->model()->latest('id');

        $grid->column('id', __('Id'));

        $grid->column('photo_title', __('标题'))->editable();

        $grid->column('photo_img', __('封面图片'))->image('', 50, 50);

        $grid->column('photo_json', __('图片总数'))->display(function ($photo_json){
            return count($photo_json);
        });

        $grid->column('photo_click', __('点击量'))->editable();

        $grid->column('photo_show', __('是否显示'))->switch(config('system.switch'));

        $grid->column('photo_sort', __('admin.sort'))->sortable()->editable();

        $grid->column('created_at', __('添加时间'))->sortable();

        //搜索条件
        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('photo_title', '标题名称');
            //标签
            $filter->where(function ($query) {
                $tag_ids = $this->input;
                $query->whereHas('tags', function ($query) use ($tag_ids) {
                    $query->where('tag_name', 'like', '%' . $tag_ids . '%');
                });
            }, '标签', 'tag_id');

            $filter->equal('photo_show', '显示or隐藏')->radio(config('system.filter_radio'));
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
        $show = new Show(Photo::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Photo());

        $form->text('photo_title', __('标题'))->attribute('autocomplete', 'off')->required()->rules('required|max:100');

        $form->checkbox('tags','标签')->options(Tag::all()->where('tag_status', Tag::STATUS_TRUE)->pluck('tag_name', 'id'));

        $form->textarea('photo_describe', __('相册简介'));

        $form->image('photo_img','封面图')->required()->removable();

        $form->multipleImage('photo_json','所属照片')->uniqueName()->attribute('accept', 'image/*')->removable()->sortable()->rules('required');

        $form->number('photo_click', __('点击量'))->rules('required')->default(0);

        $form->switch('photo_show', __('是否显示'))->states(config('system.show'))->default(1);

        $form->number('photo_sort', __('admin.sort'))->rules('required')->default(100);

        //保存后回调
        $form->saved(function (Form $form) {

        });
        return $form;
    }
}
