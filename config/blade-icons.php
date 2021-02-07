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

        // 'default' => [
        //
        //     /*
        //     |-----------------------------------------------------------------
        //     | Icons Path
        //     |-----------------------------------------------------------------
        //     |
        //     | Provide the relative path from your app root to your SVG icons
        //     | directory. Icons are loaded recursively so there's no need to
        //     | list every sub-directory.
        //     |
        //     | Relative to the disk root when the disk option is set.
        //     |
        //     */
        //
        //     'path' => 'resources/svg',
        //
        //     /*
        //     |-----------------------------------------------------------------
        //     | Filesystem Disk
        //     |-----------------------------------------------------------------
        //     |
        //     | Optionally, provide a specific filesystem disk to read
        //     | icons from. When defining a disk, the "path" option
        //     | starts relatively from the disk root.
        //     |
        //     */
        //
        //     'disk' => '',
        //
        //     /*
        //     |-----------------------------------------------------------------
        //     | Default Prefix
        //     |-----------------------------------------------------------------
        //     |
        //     | This config option allows you to define a default prefix for
        //     | your icons. The dash separator will be applied automatically
        //     | to every icon name. It's required and needs to be unique.
        //     |
        //     */
        //
        //     'prefix' => 'icon',
        //
        //     /*
        //     |-----------------------------------------------------------------
        //     | Fallback Icon
        //     |-----------------------------------------------------------------
        //     |
        //     | This config option allows you to define a fallback
        //     | icon when an icon in this set cannot be found.
        //     |
        //     */
        //
        //     'fallback' => '',
        //
        //     /*
        //     |-----------------------------------------------------------------
        //     | Default Set Class
        //     |-----------------------------------------------------------------
        //     |
        //     | This config option allows you to define some classes which
        //     | will be applied by default to all icons within this set.
        //     |
        //     */
        //
        //     'class' => '',
        //
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global Default Class
    |--------------------------------------------------------------------------
    |
    | This config option allows you to define some classes which
    | will be applied by default to all icons.
    |
    */

    'class' => '',

    /*
    |--------------------------------------------------------------------------
    | Global Fallback Icon
    |--------------------------------------------------------------------------
    |
    | This config option allows you to define a global fallback
    | icon when an icon in any set cannot be found. It can
    | reference any icon from any configured set.
    |
    */

    'fallback' => '',

    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | These config options allow you to define some
    | settings related to Blade Components.
    |
    */

    'components' => [

        /*
        |----------------------------------------------------------------------
        | Default Icon Name
        |----------------------------------------------------------------------
        |
        | This config option allows you to define the name
        | for the default Icon class component.
        |
        */

        'default' => 'icon',

    ],

];
