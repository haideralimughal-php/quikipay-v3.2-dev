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

    'title' => 'QuikiPay',
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

    'logo' => '<b>Quiki</b>Pay',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminLTE',

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
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Extra Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#66-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand-md',
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

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
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

    'register_url' => 'register',

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
        // [
        //     'text' => 'search',
        //     'search' => true,
        //     'topnav' => true,
        // ],
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
        // [
        //     'text'        => 'pages',
        //     'url'         => 'admin/pages',
        //     'icon'        => 'far fa-fw fa-file',
        //     'label'       => 4,
        //     'label_color' => 'success',
        // ],
        [
            'text' => 'dashboard',
            'url'  => '/home',
            'icon' => 'fas fa-fw fa-tachometer-alt'
        ],
        [
            'text' => 'transaction',
            'url'  => 'transactions/',
            'icon' => 'fas fa-fw fa-table',
        ],
         [
            'text'    => 'BACSTransactions',
            'icon'    => 'fas fa-fw fa-university',
            'can'  => 'isAdmin',
            'submenu' => [
                [
                    'text' => 'marchantTrasactions',
                    'url'  => 'bacs-transactions',
                    'icon'    => 'fas fa-fw fa-exchange-alt',
                ],
                [
                    'text' => 'customerTransactions',
                    'url'  => 'customer-bacs-transactions',
                    'icon'    => 'fas fa-fw fa-exchange-alt',
                ],
            ],
        ],
       
       
       
        // [
        //     'text' => 'genButton',
        //     'url'  => 'payment_button/',
        //     'icon' => 'fas fa-fw fa-table',
        //     'can'  => 'isMerchant'
        // ],
       
       
        [
            'text' => 'withdraw',
            'url'  => 'withdraw/wh',
            'icon' => 'fas fa-fw fa-wallet',
            'can'  => 'isMerchant'
        ],
        [
            'text' => 'withdrawRequest',
            // 'url'  => 'coin-settings/',
            'icon' => 'fas fa-fw fa-wallet',
            'can'  => 'isAdmin',
            'submenu' => [
                [
                    'text' => 'marchentRequest',
                    'icon' => 'fas fa-fw fa-spinner',
                    'url'  => 'withdrawal-requests/wr',
                ],
                [
                    'text' => 'customerRequest',
                    'icon' => 'fas fa-fw fa-spinner',
                    'url'  => 'customer-requests/wr',
                    
                ]
            ],
        ],
        [
            'text' => 'withdrawHistory',
            // 'url'  => 'coin-settings/',
            'icon' => 'fas fa-fw fa-history',
            'can'  => 'isAdmin',
            'submenu' => [
                [
                    'text' => 'marchentHistory',
                    'icon' => 'fas fa-fw fa-tasks',
                    'url'  => 'withdrawal-requests/wh',
                ],
                [
                    'text' => 'customerHistory',
                    'icon' => 'fas fa-fw fa-tasks',
                    'url'  => 'customer-requests/wh',
                    
                ]
            ],
        ],
         [
            'text' => 'withdrawHistory',
            'url' => 'withdrawal-requests/wh',
            'icon' => 'fas fa-fw fa-history',
            'can'  => 'isMerchant',
        ],
        [
            'text' => 'payout',
            'url'  => 'withdraw/ph',
            'icon' => 'fas fa-fw fa-credit-card',
            'can'  => 'isMerchant'
        ],
        [
            'text' => 'payoutRequest',
            'url'  => 'withdrawal-requests/pr',
            'icon' => 'fas fa-fw fa-history',
            'can'  => 'isAdmin'
        ],
         [
            'text' => 'payout_history',
            'url'  => 'withdrawal-requests/ph',
            'icon' => 'fas fa-fw fa-history',
        ],
         [
            'text' => 'convert_currency',
            'url'  => 'convert-currency',
            'icon' => 'fas fa-fw fa-recycle',
            'can'  => 'isMerchant'
        ],
        [
            'text' => 'converter_history',
            'url' => 'converter-history',
            'icon' => 'fas fa-fw fa-table',
        ],
         [
            'text'    => 'marketOrder',
            'icon'    => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'openOrders',
                    'url'  => '/open-orders',
                ],
                [
                    'text' => 'closeOrders',
                    'url'  => '/close-orders',
                ],
            ],
        ],
        [
            'text' => 'Shared Balances',
            'url' => '/shared-balances',
            'icon' => 'fas fa-fw fa-table',
            'can'  => 'isAdmin',
        ],
        // [
        //     'text' => 'Customer Withdrawals',
        //     'url'  => 'customer-withdrawals/',
        //     'icon' => 'fa fa-check-circle',
        //     'can'  => 'isAdmin'
        // ],
        // [
        //     'text' => 'withdrawRequest',
        //     'url'  => 'withdrawal-requests/wr',
        //     'icon' => 'fas fa-fw fa-wallet',
        //     'can'  => 'isAdmin'
        // ],
        // [
        //     'text' => 'withdrawHistory',
        //     'url'  => 'withdrawal-requests/wh',
        //     'icon' => 'fas fa-fw fa-history',
        // ],
       
        [
            'text' => 'Merchants',
            'url'  => 'users/',
            'icon' => 'fas fa-fw fa-table',
            'can'  => 'isAdmin'
        ],
         [
            'text' => 'KYC Verification',
            'url'  => 'kyc-verifications/',
            'icon' => 'fa fa-check-circle',
            'can'  => 'isAdmin'
        ],
         
       
        // [
        //     'text' => 'adminRevenue',
        //     'url'  => 'admin-revenue',
        //     'icon' => 'fas fa-fw fa-dollar-sign',
        // ],
        [
            'text' => 'report',
            'url'  => 'report',
            'icon' => 'fas fa-flag',
        ],
        [
            'text' => 'apiKey',
            'url'  => 'apikey',
            'icon' => 'fas fa-fw fa-key',
            'can'  => 'isMerchant'
        ],
         [
            'text' => 'settings',
            // 'url'  => 'coin-settings/',
            'icon' => 'fas fa-fw fa-cogs',
            'can'  => 'isMerchant',
            'submenu' => [
                [
                    'text' => 'coinSet',
                    'url'  => '/coin-settings',
                ],
                [
                    'text' => 'emailSet',
                    'url'  => '/email-settings',
                    
                ],
                [
                    'text' => 'min_order',
                    'url'  => '/order_limit_settings',
                    'can'  => 'isMerchant',
                ],
            ],
        ],
        
        ['header' => 'account_settings'],
        [
            'text' => 'profile',
            'url'  => 'settings/profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'edit',
            'url'  => 'settings/edit',
            'icon' => 'fas fa-fw fa-user-edit',
        ],
        [
            'text' => 'fees',
            'url'  => 'get_fees_for_merchant_panel',
            'icon' => 'fas fa-dollar-sign',
            'can'  => 'isMerchant'
        ],
        [
            'text' => 'security',
            'url'  => 'settings/security',
            'icon' => 'fas fa-fw fa-lock',
        ],
        [
            'text' => 'BankInformation',
            'url'  => 'settings/bank-info',
            'icon' => 'fas fa-fw fa-university',
            'can'  => 'isAdmin'
        ],

        
        // ['header' => 'labels'],
        // [
        //     'text'       => 'important',
        //     'icon_color' => 'red',
        // ],
        // [
        //     'text'       => 'warning',
        //     'icon_color' => 'yellow',
        // ],
        // [
        //     'text'       => 'information',
        //     'icon_color' => 'cyan',
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
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
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
            'name' => 'bsCustomFileInput',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js'
                ]
            ]
        ],
        [
            'name' => 'moment',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js'
                ]
            ]
        ],
        [
            'name' => 'ekkoLightbox',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/ekko-lightbox/ekko-lightbox.min.js'
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/ekko-lightbox/ekko-lightbox.css',
                ]
            ]
        ],
        [
            'name' => 'select2BS4',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css'
                ]
            ]
        ],
        [
            'name' => 'daterangepicker',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.js'
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.css',
                ]
            ]
        ], 
        [
            'name' => 'ionRangeslider',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/ion-rangeslider/js/ion.rangeSlider.min.js'
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/ion-rangeslider/css/ion.rangeSlider.min.css',
                ]
            ]
        ],        [
            'name' => 'bootstrapSlider',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-slider/bootstrap-slider.min.js'
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-slider/css/bootstrap-slider.min.css',
                ]
            ]
        ],
        [
            'name' => 'dataTables-buttons',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-buttons/js/buttons.html5.min.js',
                    'location' => 'vendor/datatables-buttons/js/buttons.colVis.min.js',
                    'location' => 'vendor/datatables-buttons/js/buttons.flash.min.js',
                    'location' => 'vendor/datatables-buttons/js/buttons.print.min.js',
                    'location' => 'vendor/datatables-buttons/js/buttons.bootstrap4.min.js',
                    'location' => 'vendor/datatables-buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-buttons/css/buttons.bootstrap4.min.css',
                ]
            ]
        ],
        [
            'name' => 'bootstrapSwitch',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-switch/js/bootstrap-switch.min.js'
                ]
            ]
        ],
        [
            'name' => 'icheck-bootstrap',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/icheck-bootstrap/icheck-bootstrap.css'
                ]
            ]
        ],
        [
            'name' => 'Datatables',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
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
