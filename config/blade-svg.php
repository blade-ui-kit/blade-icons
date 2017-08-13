<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SVG Path
    |--------------------------------------------------------------------------
    |
    | This value is the path to the directory of individual SVG files. This
    | path is then resolved internally. Please ensure that this value is
    | set relative to the root directory and not the public directory.
    |
    */

    'svg_path' => 'resources/assets/svg',

    /*
    |--------------------------------------------------------------------------
    | Spritesheet Path
    |--------------------------------------------------------------------------
    |
    | If you would rather have one spritesheet than a lot of individual SVG
    | files, you may specify a path to a spritesheet. The SVG images are
    | extracted from this spritesheet to be rendered out individually.
    |
    */

    'spritesheet_path' => 'resources/assets/svg/spritesheet.svg',

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
    | This value will determine whether or not the SVG should be rendered inline
    | or if it should reference a spritesheet through a <use> element.
    |
    | Default: true
    |
    */

    'inline' => true,

    /*
    |--------------------------------------------------------------------------
    | Optional Class
    |--------------------------------------------------------------------------
    |
    | If you would like to have CSS classes applied to your SVGs, you must
    | specify them here. Much like how you would define multiple classes
    | in an HTML attribute, you may separate each class using a space.
    |
    | Default: ''
    |
    */

    'class' => '',
];
