<?php

namespace App\Admin\Controllers\Collect\Music;

use App\Models\Collect\Music\Music;
use App\Models\Collect\Music\SongList;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MusicController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '音乐管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Music());
        //默认排序
        $grid->model()->latest('id');

        $grid->column('id', __('Id'));

        $grid->column('song', __('所属歌单'))->display(function ($songList) {
            $songList = array_map(function ($songList) {
                return "<span class='label label-success'>{$songList['song_list_title']}</span>";
            }, $songList);
            return join('&nbsp;', $songList);
        });

        $grid->column('music_name', __('音乐名称'))->editable();

        $grid->column('music_img', __('封面图片'))->image('', 50, 50);

        $grid->column('article_click', __('点击量'))->editable();

        $grid->column('music_show', __('是否显示'))->switch(config('system.show'));

        $grid->column('music_play', __('添加播放列表'))->switch(config('system.switch_yes'));

        $grid->column('music_sort', __('admin.sort'))->sortable()->editable();

        $grid->column('created_at', __('添加时间'))->sortable();

        //搜索条件
        $grid->filter(function (Grid\Filter $filter) {

            $filter->like('music_name', '音乐名称');
            //歌单
            $filter->where(function ($query) {
                $song_list_title = $this->input;
                $query->whereHas('song', function ($query) use ($song_list_title) {
                    $query->where('song_list_title', 'like', '%' . $song_list_title . '%');
                });
            }, '歌单搜索', 'song_list_title');

            $filter->equal('music_show', '显示or隐藏')->radio(config('system.filter_radio'));

            $filter->equal('music_play', '播放列表')->radio(config('system.filter_radio'));

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
        $show = new Show(Music::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Music());

        $form->text('music_name', __('音乐名称'))->attribute('autocomplete', 'off')->required()->rules('required|max:100');

        $form->textarea('music_describe', __('音乐简介'));

        $form->image('music_img', '封面图')->required()->removable();

        $form->chunk_file('music_url', '歌曲播放链接');

        $form->number('article_click', __('点击量'))->rules('required')->default(0);

        $form->switch('music_show', __('是否显示'))->states(config('system.show'))->default(1);

        $form->switch('music_play', __('添加播放列表'))->states(config('system.switch_yes'))->default(1);

        $form->multipleSelect('song', '选择歌单')->options(SongList::query()->where('song_list_show', true)->pluck('song_list_title', 'id'));

        $form->number('music_sort', __('admin.sort'))->rules('required')->default(100);

        return $form;
    }
}
