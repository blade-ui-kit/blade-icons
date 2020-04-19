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

            'sprite-sheet' => [

                /*
                |--------------------------------------------------------------------------
                | Sprite Sheet Path
                |--------------------------------------------------------------------------
                |
                | If you would rather have one sprite sheet than a lot of individual SVG
                | files, you may specify a path to a sprite sheet. The SVG images are
                | extracted from this sprite sheet to be rendered out individually.
                |
                */

                'path' => 'resources/sprite-sheet.svg',

                /*
                |--------------------------------------------------------------------------
                | Sprite Sheet URL
                |--------------------------------------------------------------------------
                |
                | If you don't want to embed the sprite sheet directly in your markup and
                | would rather reference an external URL, you can specify the path to
                | the external sprite sheet to use with this configuration option.
                |
                */

                'url' => 'http://example.com/sprite-sheet.svg',

                /*
                |--------------------------------------------------------------------------
                | Sprite Prefix
                |--------------------------------------------------------------------------
                |
                | If the ID attributes of the SVGs in your sprite sheet have a prefix,
                | you can configure that using the prefix option.
                |
                */

                'prefix' => 'icon',

            ],

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

    'class' => 'icon icon-default',

];
