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

    /**
     * Media controller
     */
    'media_controller' => \Oxygencms\Core\Controllers\MediaController::class,

    /**
     * Image conversions
     */
    'image_conversions' => [
        'thumb' => 160,
        'xs' => 320,
        'sm' => 640,
        'md' => 1280,
        'lg' => 1920,
    ],

    /**
     * Accepted image types
     */
    'image_types' => [
        'image/jpg',
        'image/jpeg',
        'image/bmp',
        'image/png',
        'image/svg+xml',
    ],

    /**
     * Accepted video types
     */
    'video_types' => [
        'video/mp4',
    ],

    /**
     * The max count of the existing Temporary models
     */
    'temporaries_count' => 10,
];
