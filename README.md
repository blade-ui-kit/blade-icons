<p align="center">
    <img src="https://github.com/blade-ui-kit/art/blob/main/socialcard-blade-icons.png" width="1280" title="Social Card Blade UI Kit">
</p>

# Blade Icons

<a href="https://github.com/blade-ui-kit/blade-icons/actions?query=workflow%3ATests">
    <img src="https://github.com/blade-ui-kit/blade-icons/workflows/Tests/badge.svg" alt="Tests">
</a>
<a href="https://github.styleci.io/repos/66956607">
    <img src="https://github.styleci.io/repos/66956607/shield?style=flat" alt="Code Style">
</a>
<a href="https://packagist.org/packages/blade-ui-kit/blade-icons">
    <img src="https://img.shields.io/packagist/v/blade-ui-kit/blade-icons" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/blade-ui-kit/blade-icons">
    <img src="https://img.shields.io/packagist/dt/blade-ui-kit/blade-icons" alt="Total Downloads">
</a>

A package to easily make use of SVG icons in your Laravel Blade views. Originally "Blade SVG" by [Adam Wathan](https://twitter.com/adamwathan).

Looking for a specific icon? Try our icon search: https://blade-ui-kit.com/blade-icons#search

*Join the Discord server: https://discord.gg/Vev5CyE*

## Icon Packages

This package is a base package to make it easy for you to use SVG icons in your app. If you want to start using a specific icon set, we offer the following ones below:

- [Blade Heroicons](https://github.com/blade-ui-kit/blade-heroicons)
- [Blade Zondicons](https://github.com/blade-ui-kit/blade-zondicons)

We're not accepting requests to build new icon packages ourselves but you can [start building your own](#building-packages).

### Third Party

In addition to the official packages from above there's also quite some third party ones. Thanks to the community for contributing these!

- [Blade Bootstrap Icons](https://github.com/davidhsianturi/blade-bootstrap-icons) by [David H. Sianturi](https://github.com/davidhsianturi)
- [Blade Boxicons](https://github.com/jfvoliveira/blade-boxicons) by [João Oliveira](https://github.com/jfvoliveira)
- [Blade Brand Icons](https://github.com/sadegh19b/blade-brand-icons) by [Sadegh Barzegar](https://github.com/sadegh19b)
- [Blade CoreUI Icons](https://github.com/ublabs/blade-coreui-icons) by [Adrián UB](https://github.com/adrian-ub)
- [Blade Cryptocurrency Icons](https://github.com/codeat3/blade-cryptocurrency-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade CSS Icons](https://github.com/khatabwedaa/blade-css-icons) by [khatabWedaa](https://github.com/khatabwedaa)
- [Blade Entypo](https://github.com/owenvoke/blade-entypo) by [Owen Voke](https://github.com/owenvoke)
- [Blade Eva Icons](https://github.com/Hasnayeen/blade-eva-icons) by [Nehal Hasnayeen](https://github.com/Hasnayeen)
- [Blade Evil Icons](https://github.com/codeat3/blade-evil-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Feather Icons](https://github.com/brunocfalcao/blade-feather-icons) by [Bruno Falcão](https://github.com/brunocfalcao)
- [Blade File Icons](https://github.com/codeat3/blade-file-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Font Audio](https://github.com/codeat3/blade-fontaudio) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Font Awesome](https://github.com/owenvoke/blade-fontawesome) by [Owen Voke](https://github.com/owenvoke)
- [Blade Fork Awesome](https://github.com/codeat3/blade-forkawesome) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Github Octicons](https://github.com/Activisme-be/Blade-github-octicons) by [Tim Joosten](https://github.com/Tjoosten)
- [Blade Google Material Design Icons](https://github.com/codeat3/blade-google-material-design-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Icon Park Icons](https://github.com/codeat3/blade-iconpark) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Ikonate Icons](https://github.com/codeat3/blade-ikonate) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Ionicons](https://github.com/Faisal50x/blade-ionicons) by [Faisal Ahmed](https://github.com/Faisal50x)
- [Blade Microns](https://github.com/codeat3/blade-microns) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Remix Icon](https://github.com/skydiver/blade-icons-remix) by [Martin M.](https://github.com/skydiver)
- [Blade System UIcons](https://github.com/codeat3/blade-system-uicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Tabler Icons](https://github.com/ryangjchandler/blade-tabler-icons) by [Ryan Chandler](https://github.com/ryangjchandler)
- [Blade Teeny Icons](https://github.com/codeat3/blade-teeny-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Typicons](https://github.com/codeat3/blade-typicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Unicons](https://github.com/codeat3/blade-unicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade VSCode Codicons](https://github.com/codeat3/blade-codicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Weather Icons](https://github.com/codeat3/blade-weather-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)

## Requirements

- PHP 7.4 or higher
- Laravel 8.0 or higher

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

Make sure that the path defined for this icon set exists. By default it's `resources/svg`.

## Updating

Please refer to [`the upgrade guide`](UPGRADE.md) when updating the library.

## Caching

When working with Blade Icons, and third party icons in particularly, you'll often be working with large icon sets. This can slow down your app tremendously, especially when making use of [Blade components](#components). To solve this issue, Blade Icons ships with caching support. To enable icon caching you can run the following command:

```blade
php artisan icons:cache
```

This will create a `blade-icons.php` file in `bootstrap/cache` similar to the `packages.php` cached file. It'll contain a manifest of all known sets and icons with their path locations. 

Caching icons means you won't be able to add extra icons, change paths for icon sets or install/remove icon packages. To do so make sure you first clear the icons cache and cache after you've made these changes:

```bash
php artisan icons:clear
```

It's a good idea to add the `icons:cache` command as part of your deployment pipeline and always cache icons in production. 

Alternatively, you may choose to [disable Blade components](#disabling-components) entirely.

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

> ⚠️ Always make sure you're pointing to existing directories.

#### Multiple Paths

In addition to a single path, you may define multiple paths for a single set with the `paths` option instead:

```php
<?php

return [
    'sets' => [
        'default' => [
            'paths' => [
                'resources/images/icon-set',
                'resources/images/other-icon-set',
            ],
        ],
    ],
];
```

This gives you the benefit from grouping icons from different paths under a single set where you can define the same prefix and default classes.

> ⚠️ When using multiple paths instead of one, Blade Icons will return the first icon it finds when an icon name is present in more than one path. Please ensure you use unique icon names when registering multiple paths if you want to retrieve the correct icon.

### Filesystem Disk

If you host your icons on an external filesystem storage you can set the `disk` option for an icon set to a disk defined in your `filesystems.php` config file. For example, you might store your icons on an AWS S3 bucket which is set in your `filesystems.php` config file with a disk key of `s3-icons`:

```php
<?php

return [
    'sets' => [
        'default' => [
            'path' => '/',
            'disk' => 's3-icons',
        ],
    ],
];
```

And from now on our default set will pull the icons from the S3 bucket. Also notice we've adjusted the path to `/` because we store our icons in the root directory of this S3 bucket. If you have several icon sets uploaded to the same disk you can set your paths accordingly:

```php
<?php

return [
    'sets' => [
        'heroicons' => [
            'path' => 'heroicons',
            'disk' => 's3-icons',
            'prefix' => 'heroicon',
        ],
        'zondicons' => [
            'path' => 'zondicons',
            'disk' => 's3-icons',
            'prefix' => 'zondicon',
        ],
    ],
];
```

### Fallback Icons

If you want to provide a fallback icon when an icon cannot be found, you may define the `fallback` option on a specific set:

```php
<?php

return [
    'sets' => [
        'default' => [
            'fallback' => 'cake',
        ],
    ],
];
```

Now when you try to resolve a non-existing icon for the default icon set, it'll return the rendered "cake" icon instead.

You can also provide a global fallback icon instead. This icon will be used when an icon cannot be found and the set doesn't have its own fallback icon defined. It can reference any icon from any registered icon set.

```php
<?php

return [
    'default' => 'heroicon-cake',
];
```

> ⚠️ There's one caveat when using fallback icons and that is that they don't work when using [Blade Components](#components). In this case, Laravel will throw an exception that the component cannot be found. If you want to make use of fallback icons please consider one of the other usages.

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

When an icon in the default set has a name which collides with a prefix from a set then the icon from the default set is retrieved first.

Please note that it's best practice that your icons themselves do not have the prefix in their name. So if you have a prefix in your set called `icon` and your icons are named `icon-example.svg` you should rename them to `example.svg`. Otherwise you can run into unexpected name resolving issues.

It's also important to note that icon prefixes cannot contain dashes (`-`) as this is the delimiter which we use to split it from the rest of the icon name.

### Default Classes

You can optionally define classes which will be applied to every icon by filling in the `class` setting in your `blade-icons.php` config file:

```php
<?php

return [
    'class' => 'icon icon-default',
];
```

If you don't want any classes to be applied by default then leave this as an empty string. Additionally, the same option is available in sets so you can set default classes on every set.

The sequence in which classes get applied is `<global classes> <set classes> <explicit classes>`. You can always override this by passing an explicit class with your attributes. Component classes cannot be overridden.

### Default Attributes

You can also optionally define some attributes which will be added to every icon in the `attributes` setting of your `blade-icons.php` config file:

```php
<?php

return [
    'attributes' => [
        'width' => 50,
        'height' => 50,
    ],
];
```

This always needs to be an associative array.  Additionally, the same option is available in sets so you can set default attributes on every set.

It is not possible to overwrite existing attributes on SVG icons. If you already have attributes defined on icons which you want to override, remove them first.

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

> ⚠️ Note that with Blade components, using a prefix is always required, even when referencing icons from the default set.

#### Default Component

If you don't want to use the component syntax from above you can also make use of the default `Icon` component that ships with Blade Icons. Simply pass the icon name through the `$name` attribute:

```blade
<x-icon name="camera"/>
```

If you want to use a different name for this component instead you can customize the `components.default` option in your `blade-icons.php` config file:

```php
<?php

return [
    'components' => [
        'default' => 'svg',
    ],
];
```

Then reference the default icon as follow:

```blade
<x-svg name="camera"/>
```

You can also completely disable this default component if you want by setting its name to `null`:

```php
<?php

return [
    'components' => [
        'default' => null,
    ],
];
```

#### Disabling Components

Although they're enabled by default, if you don't wish to use components at all you may choose to disable them completely by setting the `components.disabled` setting in your `blade-icons.php` config file to true:

```php
<?php

return [
    'components' => [
        'disabled' => true,
    ],
];
```

Doing this makes sense when you're only using [the directive](#directive) or [the helper](#helper) and can improve overall performance.

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

Make sure to load your SVGs from the `register` method of your package's service provider. Provide the path to your SVGs and provide your own unique set name and component prefix:

```php
use BladeUI\Icons\Factory;

public function register(): void
{
    $this->callAfterResolving(Factory::class, function (Factory $factory) {
        $factory->add('heroicons', [
            'path' => __DIR__.'/../resources/svg',
            'prefix' => 'heroicon',
        ]);
    });
}
```

Now your icons can be referenced using a component, directive or helper:

```blade
<x-heroicon-o-bell/>

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
