<?php

namespace App\Admin\Controllers\Website;

use App\Models\Notes\Tag;
use App\Models\Website\Nav;
use App\Models\Website\Notice;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NoticeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '公告管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Notice());

        $grid->model()->orderBy('notice_show', 'desc')->orderBy('id', 'desc');

        $grid->column('id', __('ID'));

        $grid->column('notice_title', __('公告标题'))->editable();

        $grid->nav_type()->nav_title(__('导航位置'));

        $grid->column('notice_sort', __('公告排序'));

        $grid->column('notice_show', __('是否显示'))->using([1 => '显示', 2 => '隐藏']);

        $grid->column('created_at', __('添加时间'));

        //搜索条件
        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('notice_title', '标题名称');

            $navList = Nav::query()->where('nav_type', Nav::NAV_TYPE_TOP)->pluck('nav_title', 'id');

            $filter->equal('nav_id', '导航栏位置')->radio($navList);
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
        $show = new Show(Notice::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Notice());

        $form->text('notice_title', '公告标题')->attribute('autocomplete', 'off')->required()->rules('required|max:40');

        $form->select('nav_id', __('导航栏位置'))->options(
            Nav::query()->where('nav_type', Nav::NAV_TYPE_TOP)->pluck('nav_title', 'id')
        )->required();

        $form->simditor('notice_content', '公告内容')->rules('required');

        $form->number('notice_sort', '公告排序')->default(100)->rules('integer|between:0,99999');

        $form->switch('notice_show', '是否显示')->states(config('system.show'))->default(1);


        return $form;
    }
}
