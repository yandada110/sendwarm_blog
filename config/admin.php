<?php

return [

    /*
    * 站点标题
    */
    'name' => 'send_warm',

    /*
      * 页面顶部 Logo
      */
    'logo' => '<b>send_warm</b> 后台管理',

    /*
     * 页面顶部小 Logo
     */
    'logo-mini' => '<b>SW</b>',

    /*
    * Laravel-Admin 启动文件路径
    */
    'bootstrap' => app_path('Admin/bootstrap.php'),

    /*
     * 路由配置
     */
    'route' => [

        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'admin'],
    ],

    /*
     * Laravel-Admin 的安装目录
     */
    'directory' => app_path('Admin'),

    /*
     * Laravel-Admin 页面标题
     */
    'title' => 'SendWarm',

    /*
      * 是否使用 https
      */
    'https' => env('ADMIN_HTTPS', false),

    /*
     * Laravel-Admin 用户认证设置
     */
    'auth' => [

        'controller' => App\Admin\Controllers\AuthController::class,

        'guard' => 'admin',

        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => Encore\Admin\Auth\Database\Administrator::class,
            ],
        ],

        // 是否展示 保持登录 选项
        'remember' => true,

        // 登录页面 URL
        'redirect_to' => 'auth/login',

        // 无需用户认证即可访问的地址
        'excepts' => [
            'auth/login',
            'auth/logout',
        ],
    ],

    /*
    * Laravel-Admin 文件上传设置
    */
    'upload' => [

        // Disk in `config/filesystem.php`.
        'disk' => env('UPLOAD_TYPE'),

        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file'  => 'files',
        ],
    ],

    /*
      * Laravel-Admin 数据库设置
      */
    'database' => [

        // Database connection for following tables.
        'connection' => '',

        // User tables and model.
        'users_table' => 'admin_users',
        'users_model' => Encore\Admin\Auth\Database\Administrator::class,

        // Role table and model.
        'roles_table' => 'admin_roles',
        'roles_model' => Encore\Admin\Auth\Database\Role::class,

        // Permission table and model.
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Encore\Admin\Auth\Database\Permission::class,

        // Menu table and model.
        'menu_table' => 'admin_menu',
        'menu_model' => Encore\Admin\Auth\Database\Menu::class,

        // Pivot table for table above.
        'operation_log_table'    => 'admin_operation_log',
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table'       => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table'        => 'admin_role_menu',
    ],

    /*
     * Laravel-Admin 操作日志设置
     */
    'operation_log' => [

        'enable' => true,

        /*
         * 只记录以下类型的请求
         */
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],

        /*
         * 不记操作日志的路由
         */
        'except' => [
            'admin/auth/logs*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Indicates whether to check route permission.
    |--------------------------------------------------------------------------
    */
    'check_route_permission' => true,

    /*
    |--------------------------------------------------------------------------
    | Indicates whether to check menu roles.
    |--------------------------------------------------------------------------
    */
    'check_menu_roles'       => true,

    /*
    |--------------------------------------------------------------------------
    | User default avatar
    |--------------------------------------------------------------------------
    |
    | Set a default avatar for newly created users.
    |
    */
    'default_avatar' => '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg',

    /*
       * 地图组件提供商
       */
    'map_provider' => 'google',

    /*
     * 页面风格
     * @see https://adminlte.io/docs/2.4/layout
     */
    'skin' => 'skin-black',

    /*
    |--------------------------------------------------------------------------
    | Application layout
    |--------------------------------------------------------------------------
    |
    | This value is the layout of admin pages.
    | @see https://adminlte.io/docs/2.4/layout
    |
    | Supported: "fixed", "layout-boxed", "layout-top-nav", "sidebar-collapse",
    | "sidebar-mini".
    |
    */
    'layout' => ['sidebar-mini'],

    /*
    * 登录页背景图
    */
    'login_background_image' => 'https://img.zcool.cn/community/0135a75b552aa5a8012036be80cf41.jpg@1280w_1l_0o_100sh.jpg',

    /*
     * 显示版本
     */
    'show_version' => true,

    /*
      * 显示环境
      */
    'show_environment' => true,

    /*
     * 菜单绑定权限
     */
    'menu_bind_permission' => true,

    /*
    * 默认启用面包屑
    */
    'enable_default_breadcrumb' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable assets minify
    |--------------------------------------------------------------------------
    */
    'minify_assets' => [

        // Assets will not be minified.
        'excepts' => [

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable sidebar menu search
    |--------------------------------------------------------------------------
    */
    'enable_menu_search' => true,

    /*
    |--------------------------------------------------------------------------
    | Alert message that will displayed on top of the page.
    |--------------------------------------------------------------------------
    */
    'top_alert' => '',

    /*
    |--------------------------------------------------------------------------
    | The global Grid action display class.
    |--------------------------------------------------------------------------
    */
//    'grid_action_class' => \Encore\Admin\Grid\Displayers\DropdownActions::class, //新版标签按钮不好用
    'grid_action_class' => \Encore\Admin\Grid\Displayers\Actions::class, //使用旧版标签按钮
    /*
     * 扩展所在的目录.
     */
    'extension_dir' => app_path('Admin/Extensions'),

    /*
     * 扩展设置.
     */
    'extensions' => [
        'editormd' => [
            // Set to false if you want to disable this extension
            'enable' => true,
            // Set to true if you want to take advantage the screen length for your editormd instance.
            'wideMode' => false,
            // Set to true when the instance included in larave-admin tab component.
            'dynamicMode' => false,
            // Editor.js configuration (Refer to http://pandao.github.io/editor.md/)
            'config' =>
                [
                    'path' => '/vendor/laravel-admin-ext/editormd/editormd-1.5.0/lib/',
                    'width' => '100%',
                    'height' => 600,
                    'emoji' => true,
                    'imageUpload' => true,
                    'imageFormats' => ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                    'imageUploadURL' => '/admin/upload_files?file=editormd-image-file',

                ]
        ],
        'configx' => [
            // Set to `false` if you want to disable this extension
            'enable' => true,
            'tabs' => [
                'base' => '基本设置',
                'user_info' => '个人信息',
//                'image' => '' // if tab name is empty, get from trans : trans('admin.configx.tabs.image'); tab名称留空则从翻译中获取
            ],
            //是否检查组权限
            //if (!Admin::user()->can('confix.tab.base')) {/*hide base tab*/ } .
            'check_permission' => false
        ],
        'simditor' => [
            // Set to false if you want to disable this extension
            'enable' => true,
            // Editor configuration
            'config' => [
                'upload' => [
                    'url' => '/admin/upload_files?file=simditor_file', # example api route: admin/api/upload
                    'fileKey' => 'simditor_file',//服务器端获取文件数据的参数名
                    'connectionCount' => 3,
                    'leaveConfirm' => '上传正在进行中，您确定要离开此页面吗？'
                ],
                'tabIndent' => true,
                'toolbar' => ['title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr', '|', 'indent', 'outdent', 'alignment'],
                'toolbarFloat' => true,
                'toolbarFloatOffset' => 0,
                'toolbarHidden' => false,
                'pasteImage' => true,//允许粘贴图片
                'cleanPaste' => false,
            ]
        ]
    ],
];
