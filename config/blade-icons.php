<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Icons Sets
    |--------------------------------------------------------------------------
    |
    | With this config option you can define a couple of
    | default icon sets. Provide a key name for your icon
    | set and a combination from the options below.
    |
    */

    'sets' => [

        'default' => [

            /*
            |-----------------------------------------------------------------
            | Icons Path
            |-----------------------------------------------------------------
            |
            | Provide the relative path from your app root to your
            | SVG icons directory. Icons are loaded recursively
            | so there's no need to list every sub-directory.
            |
            */

            'path' => 'resources/svg',

            /*
            |--------------------------------------------------------------------------
            | Default Component Prefix
            |--------------------------------------------------------------------------
            |
            | This config option allows you to define a default component prefix for
            | your icons when rendered through blade components. The dash separator
            | will be applied automatically to every component.
            |
            */

            'component-prefix' => 'icon',

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Class
    |--------------------------------------------------------------------------
    |
    | This config option allows you to define some classes which
    | will be applied to all icons by default.
    |
    */

    'class' => '',

];
