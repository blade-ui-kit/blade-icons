# Blade Icons

<a href="https://github.com/adamwathan/blade-svg/actions"><img src="https://github.com/adamwathan/blade-svg/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/nothingworks/blade-svg"><img src="https://poser.pugx.org/nothingworks/blade-svg/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/nothingworks/blade-svg"><img src="https://poser.pugx.org/nothingworks/blade-svg/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/nothingworks/blade-svg"><img src="https://poser.pugx.org/nothingworks/blade-svg/license.svg" alt="License"></a>

A package to easily make use of SVG icons in your Laravel Blade views.

- [Icon Packages](#icon-packages)
- [Requirements](#requirements)
- [Installation](#installation)
- [Updating](#updating)
- [Configuration](#configuration)
    - [Defining Sets](#defining-sets)
    - [Loading Icons](#loading-icons)
        - [Referencing Icons](#referencing-icons)
        - [Icons in Subdirectories](#icons-in-subdirectories)
    - [Default Classes](#default-classes)
- [Usage](#usage)
    - [Components](#components)
    - [Directives](#directives)
    - [Helper](#helper)
- [Building Packages](#building-packages)
- [Changelog](#changelog)
- [Maintainers](#maintainers)
- [License](#license)

## Icon Packages

This package is a base package to make it easy for you to use SVG icons in your app. If you want to start using a specific icon set, we offer the following ones below:

- Coming soon...

Feel free to open up an issue on the repo to [request another set](https://github.com/nothingworks/blade-svg/issues/new).

## Requirements

- PHP 7.2 or higher
- Laravel 7.6 or higher

## Installation

```bash
composer require nothingworks/blade-svg
```

After installing the package, publish the configuration: 

```bash
php artisan vendor:publish --tag=blade-icons
```

## Updating

Please refer to [`the upgrade guide`](UPGRADE.md) when updating the library.

## Configuration

### Defining Sets

Blade Icons support multiple sets. You can define these by passing a key/value combination in the `blade-icons.php` config file's `sets` setting:

```
'sets' => [
    'default' => [
        'path' => 'resources/svg',
    ],
],
```

Feel free to add as many sets as you wish. Blade Icons ships with a `default` set for your app which you may adjust to your liking.

### Loading Icons

If you wanted to add icons from your app's `resources/svg` directory you can set a path:

```php
<?php

return [
    'sets' => [
        'default' => [
            'path' => 'resources/svg',
        ],
    ],
];
```

> Always make sure you're pointing to existing directories.

#### Referencing Icons

Note that by default Blade Icons will render icons from the `default` set. You can also reference an icon from any other set by using the `set-name:icon-name` syntax as the icon name: 

```blade
@svg('heroicons:heroicon-o-bell')
```

#### Icons In Subdirectories

Icons are loaded recursively, and you can reference icons in subdirectories using dot syntax:

```blade
@svg('solid.bell')
```

This will render the `bell` icon from the `solid` subdirectory.

### Default Classes

You can optionally define classes which will be applied to every icon by filling in the `class` setting in your `blade-icons.php` config file:

```php
<?php

return [
    'class' => 'icon icon-default',
];
```

If you don't want any classes to be applied by default then leave this as an empty string.

## Usage

There are several ways of inserting icons into your Blade templates. We personally recommend using Blade components, but you can also make use of Blade directives if you wish.

### Components

The easiest way to get started with using icons from sets are Blade components:

```blade
<x-icon-cog/>
```

Icons in subdirectories can be referenced using dot notation:

```blade
<x-icon-solid.cog/>
```

You can also pass classes to your icon components (default classes will be applied as well):

```blade
<x-icon-cog class="icon-lg"/>
```

Or any other attributes for that matter:

```blade
<x-icon-cog class="icon-lg" id="settings-icon" style="color: #555" data-baz/>
```

In the default icon set the `icon-` prefix will be applied to every icon, but you're free to adjust this in the `blade-icons.php` config file:

```
'sets' => [
    'default' => [
        'component-prefix' => 'icon',
    ],
],
```

> Note that for Blade components you cannot use the `set-name:icon-name` syntax to reference icons from specific sets. You can reference icons from specific sets by using their component prefix.

### Directives

If components aren't really your thing you can make use of the Blade directive instead. If you defined a default `icon` class in your config and want to render a `cog` icon with an `icon-lg` class you can do that like so:

```blade
<a href="/settings">
    @svg('cog', 'icon-lg') Settings
</a>

<!-- Renders.. -->
<a href="/settings">
    <svg class="icon icon-lg">
        <path d="..." fill-rule="evenodd"></path>
    </svg>

    Settings
</a>
```

Any additionally attributes can be passed as a third array argument, and they'll be rendered on the `svg` element:

```blade
@svg('cog', 'icon-lg', ['id' => 'settings-icon'])

<!-- Renders.. -->
<svg class="icon icon-lg" id="settings-icon">
    <path d="..." fill-rule="evenodd"></path>
</svg>
```

If you don't have a class to be defined you can also pass these attributes as the second parameter:

```blade
@svg('cog', ['id' => 'settings-icon'])

<!-- Renders.. -->
<svg class="icon" id="settings-icon">
    <path d="..." fill-rule="evenodd"></path>
</svg>
```

If you want to override the default classes, pass in the class as an attribute:

```blade
@svg('cog', ['class' => 'icon-lg'])

<!-- Renders.. -->
<svg class="icon-lg">
    <path d="..." fill-rule="evenodd"></path>
</svg>
```

Attributes without a key, are supported too:

```blade
@svg('cog', ['data-foo'])

<!-- Renders.. -->
<svg class="icon" data-foo>
    <path d="..." fill-rule="evenodd"></path>
</svg>
```

### Helper

If you'd like, you can use the `svg` helper to expose a fluent syntax for setting SVG attributes:

```blade
{{ svg('cog')->id('settings-icon')->dataFoo('bar')->dataBaz() }}

<!-- Renders.. -->
<svg class="icon" id="settings-icon" data-foo="bar" data-baz>
    <path d="..." fill-rule="evenodd"></path>
</svg>
```

## Building Packages

If you're interested in building your own third party package to integrate an icon set, it's pretty easy to do so. Make sure to load your SVGs from the `boot` method of your package's service provider. Provide the path to your SVGs and provide your own unique set name and component prefix:

```php
use BladeUI\Icons\Factory;

public function boot(): void
{
    $this->app->make(Factory::class)->add('heroicons', [
        'path' => __DIR__ . '/../resources/svg',
        'component-prefix' => 'heroicon',
    ]);
}
```

Also don't forget to make `nothingworks/blade-svg` a requirement of your package's `composer.json`.

## Changelog

Check out the [CHANGELOG](CHANGELOG.md) in this repository for all the recent changes.

## Maintainers

Blade Icons is developed and maintained by [Dries Vints](https://driesvints.com).

It draws inspiration from the original [Blade SVG](https://github.com/adamwathan/blade-svg) package by [Adam Wathan](https://twitter.com/adamwathan).

## License

Blade Icons is open-sourced software licensed under [the MIT license](LICENSE.md).
