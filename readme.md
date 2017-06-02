# Blade SVG

Easily use SVG images in your Blade templates, either as inline SVG or using SVG sprites.

## Installation

You can install this package via Composer by running this command in your terminal in the root of your project:

`composer require nothingworks/blade-svg`

## Getting started

Add the Blade SVG service provider to your `config/app.php` file:

```php
<?php

return [
    // ...
    'providers' => [
        // ...

        BladeSvg\BladeSvgServiceProvider::class,

        // ...
    ],
    // ...
];
```

Publish the Blade SVG config file:

```
php artisan vendor:publish --provider="BladeSvg\BladeSvgServiceProvider"
```

If you want to use the sprite sheet instead of rendering every image inline, make sure you render the hidden sprite sheet somewhere at the end of any layouts that are going to use SVGs using the `svg_spritesheet()` helper:

```
<!-- layout.blade.php -->

<!DOCTYPE html>
<html lang="en">
    <head><!-- ... --></head>
    <body>
        <!-- ... -->

        {{ svg_spritesheet() }}
    </body>
</html>
```

### Configuration

Inside `config/blade-svg.php` specify the location of your spritesheet and the path to your individual SVG images:

```php
<?php

return [
    'spritesheet_path' => 'resources/assets/svg/sprite.svg',
    'svg_path' => 'resources/assets/svg/icons',
    // ...
];
```

> These paths are resolved internally using the `base_path()` helper, so specify them relative to the root of your project.

You can also specify whether you'd like SVGs to be rendered inline by default, or to reference the SVG from the sprite sheet:

```php
<?php

return [
    // ...
    'inline' => true, // Render the full SVG inline by default
    // or...
    'inline' => false, // Reference the sprite sheet and render the image with a `use` tag
    // ...
];
```

You can specify any default CSS classes you'd like to be applied to your SVG images using the `class` option:

```php
<?php

return [
    // ...
    'class' => 'icon', // Add the `icon` class to every SVG when rendered
    // ...
];
```

You can specify multiple classes by separating them with a space, just like you would in an HTML class attribute:

```php
<?php

return [
    // ...
    'class' => 'icon inline-block',
    // ...
];
```

If the ID attributes of the SVGs in your spritesheet have a prefix, you can configure that using the `sprite_prefix` option:

```php
<?php

return [
    // ...
    'sprite_prefix' => 'zondicon-',
    // ...
];
```

## Basic Usage

To insert an SVG in your template, simply use the `@svg` Blade directive, passing the name of the SVG and optionally any additional classes:

```html
<a href="/settings">
    @svg('cog', 'icon-lg') Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="icon icon-lg">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
    </svg>
    Settings
</a>
```

To add additional attributes to the rendered SVG tag, pass an associative array as the third parameter:

```html
<a href="/settings">
    @svg('cog', 'icon-lg', ['alt' => 'Gear icon']) Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="icon icon-lg" alt="Gear icon">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
    </svg>
    Settings
</a>
```

If you have attributes to declare but no additional class, you can pass an associative array as the second parameter instead:

```html
<a href="/settings">
    @svg('cog', ['alt' => 'Gear icon']) Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="icon" alt="Gear icon">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
    </svg>
    Settings
</a>
```

If you'd like to _override_ the default class name, specify a class in the attributes array:

```html
<a href="/settings">
    @svg('cog', ['class' => 'overridden']) Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="overridden">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
    </svg>
    Settings
</a>
```

If you'd like to add an attribute that needs no value, just specify it without a key:

```html
<a href="/settings">
    @svg('cog', ['data-foo']) Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="icon" data-foo>
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
    </svg>
    Settings
</a>
```

If you'd like, you can use the `svg_image` helper directly to expose a fluent syntax for setting SVG attributes:

```html
<a href="/settings">
    {{ svg_image('cog')->alt('Alt text')->dataFoo('bar')->dataBaz() }} Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="icon" alt="Alt text" data-foo="bar" data-baz>
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
    </svg>
    Settings
</a>
```

You can force an SVG to reference the sprite sheet even if you are rendering inline by default by using the fluent syntax and chaining the `sprite` method:

```html
<a href="/settings">
    {{ svg_image('cog', 'icon-lg')->sprite() }} Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="icon icon-lg" data-foo>
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
    </svg>
    Settings
</a>
```

Similarly, you can force an SVG to render inline even if you are using sprites by default by chaining the `inline` method:

```html
<a href="/settings">
    {{ svg_image('cog', 'icon-lg')->inline() }} Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="icon icon-lg" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M3.938 6.497a6.958 6.958 0 0 0-.702 1.694L0 9v2l3.236.809c.16.6.398 1.169.702 1.694l-1.716 2.861 1.414 1.414 2.86-1.716a6.958 6.958 0 0 0 1.695.702L9 20h2l.809-3.236a6.96 6.96 0 0 0 1.694-.702l2.861 1.716 1.414-1.414-1.716-2.86a6.958 6.958 0 0 0 .702-1.695L20 11V9l-3.236-.809a6.958 6.958 0 0 0-.702-1.694l1.716-2.861-1.414-1.414-2.86 1.716a6.958 6.958 0 0 0-1.695-.702L11 0H9l-.809 3.236a6.96 6.96 0 0 0-1.694.702L3.636 2.222 2.222 3.636l1.716 2.86zM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" fill-rule="evenodd">
        </path>
    </svg>
    Settings
</a>
```
