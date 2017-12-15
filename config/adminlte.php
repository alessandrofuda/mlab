<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => env('APP_TITLE', 'AdminLTE 2'),

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => env('APP_LOGO', 'Logo'),

    'logo_mini' => env('APP_LOGO_MINI', '<b>A</b>LT'),

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'admin_dashboard_url' => 'admin/home',

    'logout_url' => 'logout',

    'logout_method' => null, // get, post, null

    'login_url' => 'login',

    'register_url' => null,   // 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */
    'menu' => [
         
        [
            'header' => 'ADMIN MENU',
            'can' => 'manage-app',   // only Admin
        ],




        [
            'text' => 'My AdminDashboards',
            'icon' => 'tachometer',
            'submenu' => [
                            [
                                'text' => 'Dashboard 1',
                                'url' => 'admin/home',
                                'icon' => 'chevron-circle-right',
                            ],
                            [
                                'text' => 'Dashboard 2',
                                'url' => 'admin/dashboard-2',
                                'icon' => 'chevron-circle-right',
                            ],
                            [
                                'text' => 'Dashboard 3',
                                'url' => 'admin/dashboard-3',
                                'icon' => 'chevron-circle-right',
                            ],
                        ],
            'can' => 'manage-app',
        ],
        /* [
            'text' => 'My AdminDashboard',
            'url'  => 'admin/home',
            'icon' => 'tachometer',
            'can'  => 'manage-app',
        ], */
        [
            'text' => 'Users Management',
            'url'  => 'admin/users',
            'icon' => 'users',
            'can'  => 'manage-app',
        ],
        [
            'text' => 'Structure Management',
            'url'  => '#',
            'icon' => 'cogs',
            'can'  => 'manage-app',
        ],
        [
            'text' => 'Tree Chart',
            'url'  => '#',
            'icon' => 'sitemap',
            'can'  => 'manage-app',
        ],
        [
            'text' => 'Dashboards Customization',
            'url'  => 'admin/dashboards-customization',
            'icon' => 'wpforms',
            'can'  => 'manage-app',
        ],
        [
            'text' => 'Export Data',
            'url'  => 'admin/exports',
            'icon' => 'download',
            'can'  => 'manage-app',
        ],
        [
            'header' => 'USER MENU',
            'can' => 'not-manage-app',
        ],
        [
            'text' => 'My Dashboards',
            'icon' => 'tachometer',
            'submenu' => [
                            [
                                'text' => 'Dashboard 1',
                                'url' => 'home',
                                'icon' => 'chevron-circle-right',
                            ],
                            [
                                'text' => 'Dashboard 2',
                                'url' => 'dashboard-2',
                                'icon' => 'chevron-circle-right',
                            ],
                            [
                                'text' => 'Dashboard 3',
                                'url' => 'dashboard-3',
                                'icon' => 'chevron-circle-right',
                            ],
                        ],
            'can' => 'not-manage-app',
        ],
        /* [
            'text' => 'My Dashboard',
            'url' => 'home',
            'icon' => 'tachometer',
            'can' => 'not-manage-app',
        ], */
        /*
        [
            'text'        => 'Pages',
            'url'         => 'admin/pages',
            'icon'        => 'file',
            'label'       => 4,
            'label_color' => 'success',
        ], 
        */
        'ACCOUNT SETTINGS',
        [
            'text' => 'My Profile',
            'url'  => '/my-profile',
            'icon' => 'user',
        ],
        [
            'text' => 'Change Password',
            'url'  => '/change-my-psw',
            'icon' => 'lock',
        ],
        'NODES',
        [
            'text' => 'My Tree',
            'url'  => '#',
            'icon' => 'sitemap',
            'can'  => 'not-manage-app',
        ],
        /*
        [
            'text'    => 'Multilevel',
            'icon'    => 'share',
            'submenu' => [
                [
                    'text' => 'Level One',
                    'url'  => '#',
                ],
                [
                    'text'    => 'Level One',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'Level Two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'Level Two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'Level Three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'Level Three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'Level One',
                    'url'  => '#',
                ],
            ],
        ],
        */
        'LABELS',
        [
            'text'       => 'Important',
            'icon_color' => 'red',
        ],
        [
            'text'       => 'Warning',
            'icon_color' => 'yellow',
        ],
        [
            'text'       => 'Information',
            'icon_color' => 'aqua',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
    ],

    /* NOTA PER GRAFICI !!!
    Also the ChartJS plugin is supported (https://www.chartjs.org/). If set to true, the necessary javascript CDN script tags will automatically be injected into the adminlte::page.blade file.

    'plugins' => [
        'datatables' => true,
        'chartjs' => true,
    ]
    */
];
