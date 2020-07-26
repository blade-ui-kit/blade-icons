<p align="center">
    <img src="https://github.com/blade-ui-kit/art/blob/main/socialcard-blade-icons.png" width="1280" title="Social Card Blade UI Kit">
</p>

# Blade Icons

<a href="https://github.com/blade-ui-kit/blade-icons/actions?query=workflow%3ATests">
    <img src="https://github.com/blade-ui-kit/blade-icons/workflows/Tests/badge.svg" alt="Tests">
</a>
<a href="https://github.com/blade-ui-kit/blade-icons/actions?query=workflow%3A%22Code+Style%22">
    <img src="https://github.com/blade-ui-kit/blade-icons/workflows/Code%20Style/badge.svg" alt="Code Style">
</a>
<a href="https://packagist.org/packages/blade-ui-kit/blade-icons">
    <img src="https://poser.pugx.org/blade-ui-kit/blade-icons/v/stable.svg" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/blade-ui-kit/blade-icons">
    <img src="https://poser.pugx.org/blade-ui-kit/blade-icons/d/total.svg" alt="Total Downloads">
</a>

A package to easily make use of SVG icons in your Laravel Blade views. Originally "Blade SVG" by [Adam Wathan](https://twitter.com/adamwathan).

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
    - [Directive](#directive)
    - [Helper](#helper)
- [Building Packages](#building-packages)
- [Changelog](#changelog)
- [Maintainers](#maintainers)
- [License](#license)

## Icon Packages

This package is a base package to make it easy for you to use SVG icons in your app. If you want to start using a specific icon set, we offer the following ones below:

- [Blade Heroicons](https://github.com/blade-ui-kit/blade-heroicons)
- [Blade Zondicons](https://github.com/blade-ui-kit/blade-zondicons)

We're not accepting requests to build new icon packages ourselves but you can [start building your own](#building-packages).

### Third Party

In addition to the official packages from above there's also quite some third party ones. Thanks to the community for contributing these!

- [Blade Bootstrap Icons](https://github.com/davidhsianturi/blade-bootstrap-icons) by [David H. Sianturi](https://github.com/davidhsianturi)
- [Blade CSS Icons](https://github.com/khatabwedaa/blade-css-icons) by [khatabWedaa](https://github.com/khatabwedaa)
- [Blade Eva Icons](https://github.com/Hasnayeen/blade-eva-icons) by [Nehal Hasnayeen](https://github.com/Hasnayeen)
- [Blade Feather Icons](https://github.com/brunocfalcao/blade-feather-icons) by [Bruno Falcão](https://github.com/brunocfalcao)
- [Blade Font Awesome](https://github.com/owenvoke/blade-fontawesome) by [Owen Voke](https://github.com/owenvoke)
- [Blade Github Octicons](https://github.com/Activisme-be/Blade-github-octicons) by [Tim Joosten](https://github.com/Tjoosten)
- [Blade Ionicons](https://github.com/Faisal50x/blade-ionicons)
- [Blade Tabler Icons](https://github.com/ryangjchandler/blade-tabler-icons) by [Ryan Chandler](https://github.com/ryangjchandler)
- [Blade Icons Remix](https://github.com/skydiver/blade-icons-remix)

## Requirements

- PHP 7.2 or higher
- Laravel 7.14 or higher

## Installation

Before installing a new package it's always a good idea to clear your config cache:

```bash
php artisan config:clear
```

Then install the package with composer:

```bash
composer require blade-ui-kit/blade-icons
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

When referencing icons with the [Blade directive](#directive) or [helper](#helper) you can omit the prefix to reference icons from the `default` set. When referencing icons from other sets, using the prefix is required.

When an icon in the default set has a name which collides with a prefix from a set then the icon from the set is retrieved first.

Please note that it's best practice that your icons themselves do not have the prefix in their name. So if you have a prefix in your set called `icon` and your icons are named `icon-example.svg` you should rename them to `example.svg`. Otherwise you can run into unexpected name resolving issues.

### Default Classes

You can optionally define classes which will be applied to every icon by filling in the `class` setting in your `blade-icons.php` config file:

```php
<?php

return [
    'class' => 'icon icon-default',
];
```

If you don't want any classes to be applied by default then leave this as an empty string. Additionally, the same option is available in sets so you can set default classes on every set.

The sequence in which classes get applied is `<global classes> <set classes> <explicit classes>`. You can always override this by passing an explicit class with your attributes. Component classes cannot be overriden.

## Usage

There are several ways of inserting icons into your Blade templates. We personally recommend using Blade components, but you can also make use of a Blade directive if you wish.

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

### Directive

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

If you're interested in building your own third party package to integrate an icon set, it's pretty easy to do so. If want to learn how to create packages first I can recommend these two excellent courses:

- [PHP Package Development](https://phppackagedevelopment.com) by [Marcel Pociot](https://twitter.com/marcelpociot)
- [Laravel Package Training](https://laravelpackage.training) by [Freek Van der Herten](https://twitter.com/freekmurze)

Make sure to load your SVGs from the `boot` method of your package's service provider. Provide the path to your SVGs and provide your own unique set name and component prefix:

```php
use BladeUI\Icons\Factory;

public function register(): void
{
    $this->callAfterResolving(Factory::class, function (Factory $factory) {
        $factory->add('heroicons', [
            'path' => __DIR__ . '/../resources/svg',
            'prefix' => 'heroicon',
        ]);
    });
}
```

Now your icons can be referenced using a component, directive or helper:

```blade
<x-heroicon-o-bell />

@svg('heroicon-o-bell')

{{ svg('heroicon-o-bell') }}
```

Don't forget to make `blade-ui-kit/blade-icons` a requirement of your package's `composer.json`.

## Changelog

Check out the [CHANGELOG](CHANGELOG.md) in this repository for all the recent changes.

## Maintainers

Blade Icons is developed and maintained by [Dries Vints](https://driesvints.com).

## License

Blade Icons is open-sourced software licensed under [the MIT license](LICENSE.md).
