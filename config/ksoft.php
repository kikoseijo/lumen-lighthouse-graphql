<?php

return [

    'version' => '2.0.5',
    'models_path' => 'Models/', // defaults "Models/"
    'backend_dashboard_route_name' => '',

    /*
     |  Klaravel user guide + scaffold generator
     |
     |  visit /klaravel/wiki/scaffold for documentation
     |  _______________________________________
     */
    'klaravel_enabled' => true,
    'klaravel_visible_for' => [], // show menu only to users id`s (all by default)
    'klaravel_route_name' => 'klaravel',
    'klaravel_middleware' => [],// ['web','auth'],
    'show_integration_hints' => true, // points to wiki links.

    'enable_plugins_menu' => false, // if you think you can help on this,,, give me a shout!

    /*
     |  Header menu customization
     |
     |  visit /klaravel/wiki/layouts for documentation
     |  _______________________________________
     */
    'menu_settings_config_location' => 'klara.settings', // info url /klaravel/wiki/layouts
    'menu_admin_config_location' => 'ksoft.admin_menu', // info url /klaravel/wiki/layouts
    'admin_menu' => [
        'kLara.index' => 'Dev. Dashboard',
        'kLara.wiki' => 'Scaffold',
        // 'ksoft.plugins.index' => 'Plugins'
    ],

    /**
     * Swagger Builder configuration
     */
    'swagger' => [
        'enabled' => false,
        'constants' => [ // Dynamic constants implementations.
            'API_HOST' => env('APP_URL', 'http://example.dev'),
        ],
        /**
         * Where and how?
         */
        'docs_route' => '/docs',
        'api_route' => '/api/documentation',
        'json_path' => storage_path('api-docs'), // defautl "Models/"
        'json_name' => 'api-docs.json',

        /**
         * Eventualy will generate crud from all models in a given path.
         * TODO: implement this feature.
         */
        'excluded_models' => [
            'Notification', 'TokenGuard',
        ],
    ],

    'style' => [
        'crud_container_wrapper' => 'container -body-block pb-5',
        'table_style' => 'table table-hover table-striped table-bordered table-sm',
        'thead' => 'thead-dark',
    ],

    'module' => [
        'backup' => [ // https://github.com/spatie/laravel-backup
            'enabled' => true,
            'route_name' => 'backup',
            // 'can_see_full_backups' => true, // activate only when got paid by client..
            'middleware' => ['web','auth'],
            'extra_arguments' => [
                '--only-db' => 'true',
            ],
        ],
        'activity_log' => [ // https://github.com/spatie/laravel-activitylog
            'enabled' => true,
            'route_name' => 'activity-logs',
            'middleware' => ['web','auth'],
        ],
        'sessions' => [ // Laravel sessions when stored on Database-
            'enabled' => true,
            'route_name' => 'sessions',
            'middleware' => ['web','auth'],
        ],
        'caches' => [ // Laravel sessions when stored on Database-
            'enabled' => true,
            'route_name' => 'caches',
            'middleware' => ['web','auth'],
        ],
        'crud' => [
            'enabled' => true,
            'header' => 'klaravel::_parts.header', // @includeIf()
            'footer' => 'klaravel::_parts.footer',
            'errors' => 'klaravel::ui.errors',
            'views_base_path' => 'back.', // might need the . at the end.
            'pagination_query_params' => ['q', 'query', 'search'], // append to pagination loop.
            'session_range_from' => 'FROM_DATE', // remembering last filter using session.
            'session_range_to' => 'TO_DATE',
            'assets' => [
                'css/app.css', // laravel defaults works, (using Bootstrap4)
            ]
        ],
    ],
    /**
     * This constants are being used to define same session keys you might be using to record
     * certain common structures like remembering limits, queries, etc..
     */
    'CONSTANTS' => [
        'take' => 'PER_PAGE',
    ],

    /**
     * CRUD builder configuration
     *
     */
    'krud' => [
        'force_rewrite' => false, // got git?... commit.
        'use_contracts' => false, // facades, when enabled uncomment contracts paths bellow.

        /**
         * Paths to save generated CRUD files
         * Will only generate enabled files here, will skype if does not find-
         * TIP: remove what you dont want to be generated.
         *
         **/
        'paths' => [
            'controller' => 'Http/Controllers/',
            // 'contract' => 'Contracts/Repositories/',
            'repo' => 'Repositories/',
            // 'update_contract' => 'Contracts/Interactions/',
            // 'create_contract' => 'Contracts/Interactions/',
            'update_interaction' => 'Interactions/',
            'create_interaction' => 'Interactions/',
        ],

        /**
         * THis option will write the routes to routes/api.php
         * You can override this value from command line using option --R
         */
        'write_routes' => false,
        'upgrade_value' => true, // Only for development.
    ],

];
