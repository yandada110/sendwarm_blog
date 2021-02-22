<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    #网站配置模块
    Route::namespace('Website')->group(function ($router) {
        #导航栏列表
        $router->resource('nav/list', NavController::class);
        #公告列表
        $router->resource('notice/list', NoticeController::class);
        #标签管理
        $router->resource('tag/list', TagController::class);
    });
    #笔记模块
    Route::namespace('Notes')->group(function ($router) {
        #文章管理
        $router->resource('article/list', ArticleController::class);
    });

    #收藏模块
    Route::namespace('Collect')->group(function () {
        #音乐
        Route::namespace('Music')->group(function ($router) {
            //歌单列表
            $router->resource('song/list', SongListController::class);
            //音乐列表
            $router->resource('music/list', MusicController::class);
        });
        #相册
        Route::namespace('Photo')->group(function ($router) {
            //相册列表管理
            $router->resource('photo/list', PhotoController::class);
        });
        #视频
        Route::namespace('Video')->group(function ($router) {
            //视频列表管理
            $router->resource('video/list', VideoController::class);
        });
    });
    #分享模块
    Route::namespace('Share')->group(function ($router) {
        #文章管理
        $router->resource('share/list', ShareController::class);
    });


    #公共模块
    Route::namespace('Common')->group(function ($router) {
        //图片上传
        $router->resource('upload_files', UploadFileController::class);
    });


});
