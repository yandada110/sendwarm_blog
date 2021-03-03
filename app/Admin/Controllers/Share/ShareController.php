<?php

namespace App\Admin\Controllers\Share;

use App\Models\Share\Share;
use App\Models\Website\Nav;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShareController extends AdminController
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
        $grid = new Grid(new Share());
        //默认排序
        $grid->model()->latest('id');

        $grid->column('id', __('Id'));

        $grid->nav_type()->nav_title(__('导航栏'));

        $grid->column('share_title', __('标题'))->editable();

        $grid->column('share_src', __('icon'))->image('', 50, 50);

        $grid->column('share_show', __('是否显示'))->switch(config('system.switch'));

        $grid->column('share_sort', __('admin.sort'))->sortable()->editable();

        $grid->column('created_at', __('添加时间'))->sortable();

        //搜索条件
        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('share_title', '标题名称');

            $navList = Nav::query()->where('nav_type', Nav::NAV_TYPE_CARD)->pluck('nav_title', 'id')->toArray();
            array_unshift($navList, '全部');
            $filter->equal('nav_id', '导航栏位置')->radio($navList);

            $filter->equal('share_sort', '显示or隐藏')->radio(config('system.filter_radio'));


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
        $show = new Show(Share::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Share());

        $form->select('nav_id', __('导航栏'))->options(
            Nav::query()->where('nav_type', Nav::NAV_TYPE_CARD)->pluck('nav_title', 'id')
        )->required();

        $form->text('share_title', __('标题'))->attribute('autocomplete', 'off')->required()->rules('required|max:200');

        $form->icon('share_icon');

        $form->image('share_src','背景');

        $form->textarea('share_intro', __('描述'));

        $form->editormd('share_describe', __('内容详情'));

        $form->url('share_link','链接地址');

        $form->switch('share_show', __('是否显示'))->states(config('system.show'))->default(1);

        $form->number('share_sort', __('admin.sort'))->rules('required')->default(1);

        return $form;
    }
}
