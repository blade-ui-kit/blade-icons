# Blade Icons

<a href="https://github.com/adamwathan/blade-svg/actions?query=workflow%3ATests">
    <img src="https://github.com/adamwathan/blade-svg/workflows/Tests/badge.svg" alt="Tests">
</a>
<a href="https://github.com/adamwathan/blade-svg/actions?query=workflow%3A%22Code+Style%22">
    <img src="https://github.com/adamwathan/blade-svg/workflows/Code%20Style/badge.svg" alt="Code Style">
</a>
<a href="https://packagist.org/packages/nothingworks/blade-svg">
    <img src="https://poser.pugx.org/nothingworks/blade-svg/v/stable.svg" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/nothingworks/blade-svg">
    <img src="https://poser.pugx.org/nothingworks/blade-svg/d/total.svg" alt="Total Downloads">
</a>

A package to easily make use of SVG icons in your Laravel Blade views.

- [Icon Packages](#icon-packages)
- [Requirements](#requirements)
- [Installation](#installation)
- [Updating](#updating)
- [Configuration](#configuration)
    - [Defining Sets](#defining-sets)
    - [Icon Paths](#icon-paths)
    - [Prefixing Icons](#prefixing-icons)
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
- Laravel 7.14 or higher

## Installation

```bash
composer require nothingworks/blade-svg
```

After installing the package, publish the configuration and **uncomment** the `default` icon set: 

```bash
php artisan vendor:publish --tag=blade-icons
```

## Updating

Please refer to [`the upgrade guide`](UPGRADE.md) when updating the library.

## Configuration

### Defining Sets

Blade Icons support multiple sets. You can define these by passing a key/value combination in the `blade-icons.php` config file's `sets` setting:

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

Feel free to add as many sets as you wish. Blade Icons ships with a `default` set for your app which you may adjust to your liking.

### Icon Paths

If you wanted to add icons from a different directory in your app, say `resources/images/svg`, you can set it like this:

```php
<?php

return [
    'sets' => [
        'default' => [
            'path' => 'resources/images/svg',
        ],
    ],
];
```

> Always make sure you're pointing to existing directories.

### Prefixing Icons

In the default icon set the `icon` prefix will be applied to every icon, but you're free to adjust this in the `blade-icons.php` config file:

```php
<?php

return [
    'sets' => [
        'default' => [
            'prefix' => 'icon',
        ],
    ],
];
```

Defining a prefix for every set is required and every prefix should be unique.

When referencing icons with the [Blade directive](#directives) or [helper](#helper) you can omit the prefix to reference icons from the `default` set.

When an icon in the default set has a name which collides with a prefix from a set then the icon from the set is retrieved first.

### Default Classes

You can optionally define classes which will be applied to every icon by filling in the `class` setting in your `blade-icons.php` config file:

```php
<?php

return [
    'class' => 'icon icon-default',
];
```

If you don't want any classes to be applied by default then leave this as an empty string. Additionally, the same option is available in sets so you can set default classes on every set.
 
The sequence in which classes get applied is `<global classes> <set classes> <explicit classes>`. You can always override this by passing an explicit class with your attributes.

## Usage

There are several ways of inserting icons into your Blade templates. We personally recommend using Blade components, but you can also make use of Blade directives if you wish.

### Components

The easiest way to get started with using icons from sets are Blade components:

```blade
<x-icon-camera/>
```

Icons in subdirectories can be referenced using dot notation:

```blade
<x-icon-solid.camera/>
```

You can also pass classes to your icon components (default classes will be applied as well):

```blade
<x-icon-camera class="icon-lg"/>
```

Or any other attributes for that matter:

```blade
<x-icon-camera class="icon-lg" id="settings-icon" style="color: #555" data-baz/>
```

> Note that with Blade components, using a prefix is always required, even when referencing icons from the default set.

### Directives

If components aren't really your thing you can make use of the Blade directive instead. If you defined a default `icon` class in your config and want to render a `camera` icon with an `icon-lg` class you can do that like so:

```blade
@svg('camera', 'icon-lg')
```

Any additionally attributes can be passed as a third array argument, and they'll be rendered on the `svg` element:

```blade
@svg('camera', 'icon-lg', ['id' => 'settings-icon'])
```

If you don't have a class to be defined you can also pass these attributes as the second parameter:

```blade
@svg('camera', ['id' => 'settings-icon'])
```

If you want to override the default classes, pass in the class as an attribute:

```blade
@svg('camera', ['class' => 'icon-lg'])
```

Attributes without a key, are supported too:

```blade
@svg('camera', ['data-foo'])
```

### Helper

If you'd like, you can use the `svg` helper to expose a fluent syntax for setting SVG attributes:

```blade
{{ svg('camera')->id('settings-icon')->dataFoo('bar')->dataBaz() }}
```

## Building Packages

If you're interested in building your own third party package to integrate an icon set, it's pretty easy to do so. Make sure to load your SVGs from the `boot` method of your package's service provider. Provide the path to your SVGs and provide your own unique set name and component prefix:

```php
use BladeUI\Icons\Factory;

public function boot(): void
{
    $this->app->make(Factory::class)->add('heroicons', [
        'path' => __DIR__ . '/../resources/svg',
        'prefix' => 'heroicon',
    ]);
}
```

Now your icons can be referenced using a component, directive or helper:

```blade
<x-heroicon-o-bell />

@svg('heroicon-o-bell')

{{ svg('heroicon-o-bell') }}
```

Don't forget to make `nothingworks/blade-svg` a requirement of your package's `composer.json`.

## Changelog

Check out the [CHANGELOG](CHANGELOG.md) in this repository for all the recent changes.

## Maintainers

Blade Icons is developed and maintained by [Dries Vints](https://driesvints.com).

It draws inspiration from the original [Blade SVG](https://github.com/adamwathan/blade-svg) package by [Adam Wathan](https://twitter.com/adamwathan).

## License

Blade Icons is open-sourced software licensed under [the MIT license](LICENSE.md).
