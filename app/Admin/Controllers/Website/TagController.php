<?php

namespace App\Admin\Controllers\Website;

use App\Models\Tag\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TagController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '标签管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tag());

        $grid->quickSearch('name');

        $grid->column('id', __('Id'));

        $grid->column('tag_name', __('admin.name'));

        $grid->column('tag_status', __('admin.status'))->switch(config('system.switch'));

        $grid->column('tag_sort', __('admin.sort'))->editable();

        $grid->column('created_at', '添加时间')->sortable();

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
        $show = new Show(Tag::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Tag());

        $form->text('tag_name', __('admin.name'));

        $form->switch('tag_status', __('admin.status'))->states(config('system.switch'))->default(1);

        $form->number('tag_sort', __('排序'))->rules('required')->default(0);

        return $form;
    }
}
