<?php

return [

    /*
        |--------------------------------------------------------------------------
        | Locales List
        |--------------------------------------------------------------------------
        |
        | List of all application locales and their county names as values. These
        | are used to localize page routes, translate model attributes and
        | validation messages. When adding new locale to this array
        | you also need to provide it's translation files.
        |
        */

    'locales' => [

        'en' => 'English',

        //        'bg' => 'Бъларски',

        'nl' => 'Dutch',

    ],

    'logs_controller' => \Oxygencms\Core\Controllers\LogsController::class,

    'logs_routes' => ['index', 'show'],

];