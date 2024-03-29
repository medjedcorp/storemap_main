<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'Storemap',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => '<b>Store</b>Map',
    // 'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img' => 'img/logo_img2.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    // 'logo_img_xl' => null,
    'logo_img_xl' => 'img/logo_img_xl2.png',
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'StoreMap',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4 sidebar-dark-pink',
    'classes_sidebar_nav' => 'text-sm',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */
    'right_sidebar' => true,
    'right_sidebar_icon' => 'far fa-question-circle',
    'right_sidebar_theme' => 'light',
    'right_sidebar_slide' => false,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'regicom',
    // 'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        [
            'text' => 'search',
            'search' => false,
            'topnav' => true,
        ],
        // [
        //     'text' => 'blog',
        //     'url'  => 'admin/blog',
        //     'can'  => 'manage-blog',
        // ],
        // [
        //     'text'        => 'pages',
        //     'url'         => 'admin/pages',
        //     'icon'        => 'far fa-fw fa-file',
        //     'label'       => 4,
        //     'label_color' => 'success',
        // ],
        // ['header' => 'account_settings'],
        // [
        //     'text' => 'profile',
        //     'url'  => 'admin/settings',
        //     'icon' => 'fas fa-fw fa-user',
        // ],
        [
            'text'    => 'item_manager',
            'icon'    => 'nav-icon fas fa-shopping-basket fa-fw',
            'can' =>  'isStaff',
            'submenu' => [
                [
                    'text' => 'item_list',
                    'url'  => 'items',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' => 'isStaff',
                ],
                [
                    'text' => 'item_registration',
                    'url'  => 'items/create',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isFree',
                ],
                [
                    'text' => 'item_bulk_manager',
                    'url'  => 'items/data',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isFree',
                ],
                [
                    'text' => 'item_store',
                    'url'  => 'items/manage',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isFree',
                ],
            ],
        ],
        [
            'text'    => 'catalog',
            'icon'    => 'nav-icon far fa-list-alt fa-fw',
            'can' =>  'isStaff',
            'submenu' => [
                [
                    'text' => 'catalog_manager',
                    'url'  => 'catalog',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isStaff',
                ],
                [
                    'text' => 'catalog_bulk',
                    'url'  => 'catalog/data',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isStaff',
                ],
            ],
        ],
        [
            'text'    => 'category_manager',
            'icon'    => 'nav-icon fas fa-clipboard fa-fw',
            'can' => 'isStaff',
            'submenu' => [
                [
                    'text' => 'category_list',
                    'url'  => 'categories',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' => 'isStaff',
                ],
                [
                    'text' => 'category_registration',
                    'url'  => 'categories/create',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isStaff',
                ],
                [
                    'text' => 'category_bulk_manager',
                    'url'  => 'categories/data',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isFree',
                ],
            ],
        ],
        [ //店舗管理
            'text'    => 'store_manager',
            'icon'    => 'nav-icon fas fa-store fa-fw',
            'can' => 'isStaff',
            'submenu' => [
                [
                    'text' => 'store_list',
                    'url'  => 'stores',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' => 'isStaff',
                ],
                [
                    'text' => 'store_registration',
                    'url'  => 'stores/create',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isFree',
                ],
                [
                    'text' => 'store_bulk_manager',
                    'url'  => 'stores/data',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isFree',
                ],
            ],
        ],
        [ // ユーザー管理
            'text'    => 'user_manager',
            'icon'    => 'nav-icon fas fa-user fa-fw',
            'can' =>  'isStaff',
            'submenu' => [
                [
                    'text' => 'user_list',
                    'url'  => 'users',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' => 'isStaff',
                ],
                [
                    'text' => 'user_registration',
                    'url'  => 'users/create',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can' =>  'isSeller',
                ],
            ],
        ],
        [ // 画像管理
            'text' => 'image_manager',
            'url'  => 'album',
            'icon' => 'nav-icon fas fa-image fa-fw',
            'can' => 'isStaff',
            'submenu' => [
                [
                    'text' => 'item_img',
                    'url'  => 'album/items',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can'  => 'isStaff',
                ],
                [
                    'text' => 'store_img',
                    'url'  => 'album/stores',
                    'icon' => 'nav-icon fas fa-angle-right fa-fw',
                    'can'  =>  'isStaff',
                ],
            ],
        ],
        [ // 設定
            'text'    => 'config',
            'icon'    => 'nav-icon fas fa-cogs fa-fw',
            'can' =>  'isStaff',
            'submenu' => [
                [
                    'text' => 'company_info',
                    'url'  => 'company/show',
                    'icon' => 'nav-icon fas fa-building fa-fw',
                    'can' => 'isStaff',
                ],
                [
                    'text' => 'change_password',
                    'url'  => 'changepassword',
                    'icon' => 'nav-icon fas fa-fw fa-lock',
                ],
                [
                    'text' => 'api_config',
                    'url'  => 'config/api',
                    'icon' => 'nav-icon fas fa-cog fa-fw',
                    'can' =>  'basic',
                    'can' =>  'isSeller',
                    'submenu' => [
                        [
                            'text' => 'sm_apitoken',
                            'url'  => 'config/import',
                            'icon' => 'nav-icon fas fa-angle-right fa-fw',
                            'can' => 'basic',
                            'can' =>  'isSeller',
                        ],
                        [
                            'text' => 'sr_api_update',
                            'url'  => 'config/sr-update',
                            'icon' => 'nav-icon fas fa-angle-right fa-fw',
                            'can' => 'basic',
                            'can' =>  'isSeller',
                        ],
                        [
                            'text' => 'sr_api_import',
                            'url'  => 'config/sr-import',
                            'icon' => 'nav-icon fas fa-angle-right fa-fw',
                            'can' => 'basic',
                            'can' =>  'isSeller',
                        ],

                    ],
                ],
                [
                    'text' => 'payment',
                    'url'  => 'payment/card',
                    'icon' => 'nav-icon far fa-credit-card fa-fw',
                    'can' =>  'isFree',
                ],
                [
                    'text' => 'accept',
                    'url'  => 'system/accept',
                    'icon' => 'nav-icon fab fa-expeditedssl fa-fw',
                    'can' => 'isAdmin',
                ],
                [
                    'text' => 'sm_cate',
                    'url'  => 'system/smcate',
                    'icon' => 'nav-icon fab fa-expeditedssl fa-fw',
                    'can' => 'isAdmin',
                ],
                [
                    'text' => 'prefecture',
                    'url'  => 'system/prefecture',
                    'icon' => 'nav-icon fab fa-expeditedssl fa-fw',
                    'can' => 'isAdmin',
                ],
            ],
        ],
        ['header' => 'guide'],
        [
            'text' => 'manual',
            'url'  => 'manual',
            'icon' => 'nav-icon fas fa-book fa-fw',
        ],
        [
            'text' => 'support',
            'url'  => 'support',
            'icon' => 'nav-icon far fa-envelope fa-fw',
        ],
        // ['header' => 'link'],
        // [
        //     'text' => 'Storemap',
        //     'url'  => '/',
        //     'icon' => 'nav-icon fas fa-home fa-fw',
        // ],
        // [ // ログイン
        //     'text' => 'login',
        //     // 'url'  => 'login',
        //     'icon' => 'nav-icon fas fa-sign-in-alt fa-fw',
        //     'can' =>  '',
        // ],
        // [ // セラー登録
        //     'text' => 'seller_register',
        //     'url'  => 'seller-register',
        //     'icon' => 'nav-icon fas fa-store fa-fw',
        //     'cant' =>  '',
        // ],
        // [ // ユーザー登録
        //     'text' => 'user_register',
        //     'url'  => 'register',
        //     'can' => 'nav-icon fas fa-user-plus fa-fw',
        //     'can' => 'guest',
        // ],
        // [ // カテゴリから探す
        //     'text' => 'category',
        //     'url'  => 'category',
        //     'icon' => 'nav-icon far fa-folder fa-fw',
        // ],
        // [
        //     'text'    => 'multilevel',
        //     'icon'    => 'fas fa-fw fa-share',
        //     'submenu' => [
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //         [
        //             'text'    => 'level_one',
        //             'url'     => '#',
        //             'submenu' => [
        //                 [
        //                     'text' => 'level_two',
        //                     'url'  => '#',
        //                 ],
        //                 [
        //                     'text'    => 'level_two',
        //                     'url'     => '#',
        //                     'submenu' => [
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //     ],
        // ],
        // ['header' => 'labels'],
        // [
        //     'text'       => 'important',
        //     'icon_color' => 'red',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'warning',
        //     'icon_color' => 'yellow',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'information',
        //     'icon_color' => 'cyan',
        //     'url'        => '#',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
