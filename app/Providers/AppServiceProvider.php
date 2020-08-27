<?php

namespace App\Providers;

use App\Services\Common\ShareInfoService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Encore\Admin\Config\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $table = config('admin.extensions.config.table', 'admin_config');
        if (Schema::hasTable($table)) {
            Config::load();
        }
        //web预加载配置
        app(ShareInfoService::class)->webInfo();

        Relation::morphMap([
            'article' => 'App\Models\Notes\Article',
            'music' => 'App\Models\Collect\Music\SongList',
            'photo' => 'App\Models\Collect\Photo\Photo',
        ]);
    }


}
