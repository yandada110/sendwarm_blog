<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use Encore\Admin\Form;

Encore\Admin\Form::forget(['map', 'editor']);
Form::init(function (Form $form) {

    $form->disableEditingCheck();

    $form->disableCreatingCheck();

    $form->disableViewCheck();

    $form->tools(function (Form\Tools $tools) {
        $tools->disableDelete();
        $tools->disableView();
    });
});

use Encore\Admin\Grid;

Grid::init(function (Grid $grid) {

    //    $grid->disableActions();//操作

//     $tags->disablePagination(); //分页

//    $grid->disableCreateButton(); //新增

//    $tags->disableRowSelector();  //列表前面的框框

//    $grid->disableColumnSelector(); //禁用选择器导出右侧

//    $grid->disableTools();  //禁用筛选刷新，列表左上角工具

//    $grid->disableExport(); //导出

//    $grid->disableFilter(); //筛选


    $grid->actions(function (Grid\Displayers\Actions $actions) {
        $actions->disableView();
    });
    $grid->filter(function ($filter){
//        $filter->expand();  //是否默认隐藏筛选
        // 去掉默认的id过滤器
        $filter->disableIdFilter();
    });
    //禁用导出
    $grid->disableExport();
});

/*
 * 大文件上传七牛
 */
Encore\Admin\Form::extend('chunk_file', \Encore\ChunkFileUpload\ChunkFileField::class);
