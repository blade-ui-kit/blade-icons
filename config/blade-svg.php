<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Icon Path
    |--------------------------------------------------------------------------
    |
    | This value is the path to the directory of individual SVG icons. This
    | path is then resolved internally. Please ensure that this value is
    | set relative to the root directory and not the public directory.
    |
    */

    'icon_path' => 'path/to/icons',

    /*
    |--------------------------------------------------------------------------
    | Spritesheet Path
    |--------------------------------------------------------------------------
    |
    | If you would rather have one spritesheet than a lot of individual svg
    | files, you may specify a path to a spritesheet. The icons are then
    | extracted from this spritesheet to be rendered out individually.
    |
    */

    'spritesheet_path' => 'path/to/spritesheet',

    /*
    |--------------------------------------------------------------------------
    | Spritesheet URL
    |--------------------------------------------------------------------------
    |
    | If you don't want to embed the spritesheet directly in your markup and
    | would rather reference an external URL, you can specify the path to
    | the external spritesheet to use with this configuration option.
    |
    */

    'spritesheet_url' => '',

    /*
    |--------------------------------------------------------------------------
    | Inline Rendering
    |--------------------------------------------------------------------------
    |
    | This value will determine whether or not the icon must be rendered as
    | an SVG element or if it must be referenced on the spritesheet. The
    | icon, if this value is false, will be rendered with a 'use' tag.
    |
    | Default: false
    |
    */

    'inline' => false,

    /*
    |--------------------------------------------------------------------------
    | Optional Class
    |--------------------------------------------------------------------------
    |
    | If you would like to have CSS classes applied to your icons, you must
    | specify them here. Much like how you would define multiple classes
    | in an HTML attribute, you may separate each class using a space.
    |
    | Default: 'icon'
    |
    */

    'class' => 'icon',
];
