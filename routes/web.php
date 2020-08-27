<?php

Route::namespace('Web')->name('web.')->group(function () {

    #需要jquery加速模块
    Route::middleware(['laravel_pjax'])->group(function () {
        #首页模块
        Route::namespace('Index')->name('index.')->group(function () {
            //首页
            Route::get('/', 'IndexController@index')->name('index.index');
        });
        #内容模块
        Route::namespace('Notes')->name('notes.')->group(function () {
            #article
            //文章
            Route::match(['get', 'post'], 'article/{nav_id?}', 'ArticleController@index')->name('article.index');
            //文章详情
            Route::get('article/{article}/detail', 'ArticleController@detail')->name('article.detail');
        });

        #收藏模块
        Route::namespace('Collect')->name('collect.')->group(function () {
            #article
            //歌单列表
            Route::match(['get', 'post'], 'music/{nav_id?}', 'MusicController@index')->name('music.index');
            //音乐列表
            Route::get('music/{song}/list', 'MusicController@list')->name('music.list');
            //相册列表
            Route::match(['get', 'post'], 'photo/{nav_id?}', 'PhotoController@index')->name('photo.index');
            //图片列表
            Route::get('photo/{photos}/list', 'PhotoController@list')->name('photo.list');
            //视频列表
            Route::match(['get', 'post'], 'video/{nav_id?}', 'VideoController@index')->name('video.index');
            //播放视频
            Route::get('video/{videos}/detail', 'VideoController@detail')->name('video.detail');
        });
    });
    Route::get('about', 'Home\AboutController@index')->name('about');
    Route::get('friends', 'Home\FriendsController@index')->name('friends');
    Route::get('card1/{nav_id?}', 'Home\CardOneController@index')->name('card1');
    Route::get('card2/{nav_id?}', 'Home\CardTwoController@index')->name('card2');
    Route::get('message', 'Home\MessageController@index')->name('message');
});

Route::name('home.')->group(function () {
    Route::post('message_msg', 'Home\MessageController@message_msg')->name('message_msg');
    Route::post('video_msg', 'Home\VideoController@video_msg')->name('video_msg');
    Route::post('friends_store', 'Home\FriendsController@store')->name('friends_store');
    Route::post('subscribe', 'Home\ArticleController@subscribe')->name('subscribe');
    Route::post('article_msg', 'Home\ArticleDetailController@article_msg')->name('article_msg');
});
