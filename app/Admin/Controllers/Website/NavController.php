<?php

namespace App\Admin\Controllers\Website;

use App\Admin\Actions\Post\GoArticle;
use App\Models\Website\Nav;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;

class NavController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '导航列表';

    protected $select_nav = array('顶级导航');

    public function __construct()
    {
        $tree_nav = modelTree(Nav::query()->orderBy('id', 'asc')->get()->toArray());

        foreach ($tree_nav as $k => $v) {
            $this->select_nav[$v['id']] = str_repeat('|----', $v['level']) . $v['nav_title'];
        }
    }

    /**
     * 首页合成列表和编辑
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        $content->header('导航管理');
        $content->description('导航列表');
        return $content->row(function (Row $row) {
            $row->column(6, Nav::tree(function ($tree) {
                $tree->disableCreate();
                $tree->branch(function ($branch) {
                    $url = '';
                    if($branch['nav_open']){
                        $lable = '<span class="label label-info" style="margin-left: 20px;">启用</span>';
                        if($branch['nav_route']){
                            $url .= '<span class="label label-info" style="margin-left: 20px;">路由：'.$branch['nav_route'];
                            if($branch['is_nav'])  $url .= '/'.$branch['id'];
                            $url .= '</span>';
                        }
                    }else{
                        $lable = '<span class="label label-default" style="margin-left: 20px;">关闭</span>';
                    }
                    return "{$branch['id']} - {$branch['nav_title']}" . $lable.$url;
                });
            }));
            $row->column(6, function (Column $column) {

                $form = new Form(new Nav);

                $form->setAction('list');

                $form->select('nav_pid', '顶级导航')->options($this->select_nav)->default(0);

                $form->text('nav_title', '导航标题')->rules('required|max:150');

                $form->select('nav_type', '导航分类')->options(Nav::$navTypeMap);

                $form->text('nav_route', '路由');

                $form->switch('is_nav', '路由启用nav_id')->states(config('system.states'))->default(true);

                $form->switch('nav_open', '是否启用')->states(config('system.states'))->default(true);

                $form->number('nav_sort', '导航排序')->default(1)->rules('integer|between:1,99999');

                $column->append($form);
            });
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Nav);

        $grid->model()->orderBy('nav_sort', 'desc')->orderBy('id', 'desc');

        $grid->column('id', 'ID');

        $grid->column('nav_title', '导航标题')->editable();

        $grid->column('nav_type', '导航类型')->using(Nav::$navTypeMap);

        $grid->column('nav_open', '是否启用')->using([1 => '启用', 2 => '关闭'])->label([
            2 => 'default',
            1 => 'success',
        ]);

        $grid->column('nav_sort', '导航排序')->editable();

        $grid->column('nav_pid', '上级导航')->display(function ($nav_pid) {
            return empty($this->select_nav[$nav_pid]) ? '暂无' : $this->select_nav[$nav_pid];
        });

        $grid->column('created_at', '创建时间');

        $grid->filter(function ($filter) {
            $filter->like('nav_title', '导航标题');
        });

        $grid->actions(function ($actions) {
            $actions->add(new GoArticle());
            $actions->disableView();
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
        $show = new Show(Nav::findOrFail($id));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Nav);

        $form->display('id', 'ID');

        $form->select('nav_pid', '顶级导航')->options($this->select_nav)->default(true);

        $form->text('nav_title', '导航标题')->attribute('autocomplete', 'off')->rules('required|max:40');

        $form->select('nav_type', '导航分类')->options(Nav::$navTypeMap);

        $form->switch('is_nav', '路由启用nav_id')->states(config('system.states'))->default(true);

        $form->text('nav_route', '路由');

        $form->switch('nav_open', '是否启用')->states(config('system.states'))->default(1);

        $form->number('nav_sort', '导航排序')->default(100)->rules('integer|between:1,99999');

        return $form;
    }

}
