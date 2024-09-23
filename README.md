<p align="center">
    <img src="https://github.com/blade-ui-kit/art/blob/main/socialcard-blade-icons.png" width="1280" title="Social Card Blade UI Kit">
</p>

# Blade Icons

<a href="https://github.com/blade-ui-kit/blade-icons/actions?query=workflow%3ATests">
    <img src="https://github.com/blade-ui-kit/blade-icons/workflows/Tests/badge.svg" alt="Tests">
</a>
<a href="https://github.com/blade-ui-kit/blade-icons/actions/workflows/coding-standards.yml">
    <img src="https://github.com/blade-ui-kit/blade-icons/actions/workflows/coding-standards.yml/badge.svg" alt="Coding Standards" />
</a>
<a href="https://packagist.org/packages/blade-ui-kit/blade-icons">
    <img src="https://img.shields.io/packagist/v/blade-ui-kit/blade-icons" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/blade-ui-kit/blade-icons">
    <img src="https://img.shields.io/packagist/dt/blade-ui-kit/blade-icons" alt="Total Downloads">
</a>

A package to easily make use of SVG icons in your Laravel Blade views. Originally "Blade SVG" by [Adam Wathan](https://twitter.com/adamwathan).

Turn...

```html
<!-- camera.svg -->
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
</svg>
```

Into...

```blade
<x-icon-camera class="w-6 h-6" />
```

Or into...

```blade
@svg('camera', 'w-6 h-6')
```

Looking for a specific icon? Try our icon search: https://blade-ui-kit.com/blade-icons#search

Any sponsorship to [help fund development](https://github.com/sponsors/driesvints) is greatly appreciated ❤️

## Icon Packages

Blade Icons is a base package to make it easy for you to use SVG icons in your app. In addition, there's also quite some third party icon set packages. Thanks to the community for contributing these!

We're not accepting requests to build new icon packages ourselves but you can [start building your own](#building-packages).

- [Blade Academicons](https://github.com/codeat3/blade-academicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Akar Icons](https://github.com/codeat3/blade-akar-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Ant Design Icons](https://github.com/codeat3/blade-ant-design-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Bootstrap Icons](https://github.com/davidhsianturi/blade-bootstrap-icons) by [David H. Sianturi](https://github.com/davidhsianturi)
- [Blade Boxicons](https://github.com/mallardduck/blade-boxicons) by [Dan Pock](https://github.com/mallardduck)
- [Blade Bytesize Icons](https://github.com/codeat3/blade-bytesize-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Carbon Icons](https://github.com/codeat3/blade-carbon-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Circle Flags](https://github.com/fahrim/blade-circle-flags) by [Fahri Meral](https://github.com/fahrim)
- [Blade Clarity Icons](https://github.com/codeat3/blade-clarity-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Coolicons](https://github.com/codeat3/blade-coolicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade CoreUI Icons](https://github.com/ublabs/blade-coreui-icons) by [Adrián UB](https://github.com/adrian-ub)
- [Blade Country Flags](https://github.com/stijnvanouplines/blade-country-flags) by [Stijn Vanouplines](https://github.com/stijnvanouplines)
- [Blade Cryptocurrency Icons](https://github.com/codeat3/blade-cryptocurrency-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade CSS Icons](https://github.com/khatabwedaa/blade-css-icons) by [khatabWedaa](https://github.com/khatabwedaa)
- [Blade Dev Icons](https://github.com/codeat3/blade-devicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Element Plus Icons](https://github.com/codeat3/blade-element-plus-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Elusive Icons](https://github.com/codeat3/blade-elusive-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Emblemicons](https://github.com/codeat3/blade-emblemicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Entypo](https://github.com/owenvoke/blade-entypo) by [Owen Voke](https://github.com/owenvoke)
- [Blade EOS Icons](https://github.com/codeat3/blade-eos-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Eva Icons](https://github.com/Hasnayeen/blade-eva-icons) by [Nehal Hasnayeen](https://github.com/Hasnayeen)
- [Blade Evil Icons](https://github.com/codeat3/blade-evil-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Feather Icons](https://github.com/brunocfalcao/blade-feather-icons) by [Bruno Falcão](https://github.com/brunocfalcao)
- [Blade File Icons](https://github.com/codeat3/blade-file-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade File Type Icons](https://github.com/log1x/blade-filetype-icons) by [Brandon Nifong](https://github.com/log1x)
- [Blade FluentUi System Icons](https://github.com/codeat3/blade-fluentui-system-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Flowbite Icons](https://github.com/themesberg/flowbite-blade-icons) by [Dominique Thomas](https://github.com/domthomas-dev)
- [Blade Font Audio](https://github.com/codeat3/blade-fontaudio) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Font Awesome](https://github.com/owenvoke/blade-fontawesome) by [Owen Voke](https://github.com/owenvoke)
- [Blade Fontisto Icons](https://github.com/codeat3/blade-fontisto-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Fork Awesome](https://github.com/codeat3/blade-forkawesome) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Github Octicons](https://github.com/Activisme-be/Blade-github-octicons) by [Tim Joosten](https://github.com/Tjoosten)
- [Blade Google Material Design Icons](https://github.com/codeat3/blade-google-material-design-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Gov Icons](https://github.com/codeat3/blade-govicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Gravity UI Icons](https://github.com/codeat3/blade-gravity-ui-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Grommet Icons](https://github.com/codeat3/blade-grommet-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Health Icons](https://github.com/troccoli/blade-health-icons) by [Giulio Troccoli-Allard](https://github.com/troccoli)
- [Blade Heroicons](https://github.com/blade-ui-kit/blade-heroicons) by [Dries Vints](https://github.com/driesvints)
- [Blade Hugeicons](https://github.com/afatmustafa/blade-hugeicons) by [Mustafa Afat](https://github.com/afatmustafa)
- [Blade Humbleicons](https://github.com/codeat3/blade-humbleicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade IcoMoon Icons](https://github.com/nerdroid23/blade-icomoon) by [Joe Sylnice](https://github.com/nerdroid23)
- [Blade Icon Park Icons](https://github.com/codeat3/blade-iconpark) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Iconic Icons](https://github.com/ItsMalikJones/blade-iconic) by [Malik Alleyne-Jones](https://github.com/ItsMalikJones)
- [Blade Iconoir](https://github.com/andreiio/blade-iconoir) by [Andrei Ioniță](https://github.com/andreiio)
- [Blade Iconsax](https://github.com/saade/blade-iconsax) by [Saade](https://github.com/saade)
- [Blade Ikonate Icons](https://github.com/codeat3/blade-ikonate) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Ionicons](https://github.com/Faisal50x/blade-ionicons) by [Faisal Ahmed](https://github.com/Faisal50x)
- [Blade Jam Icons](https://github.com/codeat3/blade-jam-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Lets Icons](https://github.com/mansoorkhan96/blade-lets-icons) by [Mansoor Ahmed](https://github.com/mansoorkhan96)
- [Blade Line Awesome Icons](https://github.com/codeat3/blade-line-awesome-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Lineicons](https://github.com/datlechin/blade-lineicons) by [Ngô Quốc Đạt](https://github.com/datlechin)
- [Blade Lucide Icons](https://github.com/mallardduck/blade-lucide-icons) by [Dan Pock](https://github.com/mallardduck)
- [Blade Majestic Icons](https://github.com/codeat3/blade-majestic-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Maki Icons](https://github.com/codeat3/blade-maki-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Material Design Icons](https://github.com/postare/blade-mdi) by [Postare](https://github.com/postare)
- [Blade Memory Icons](https://github.com/codeat3/blade-memory-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Microns](https://github.com/codeat3/blade-microns) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Mono Icons](https://github.com/codeat3/blade-mono-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Pepicons](https://github.com/codeat3/blade-pepicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Phosphor icons](https://github.com/codeat3/blade-phosphor-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Pixelarticons](https://github.com/codeat3/blade-pixelarticons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Polaris Icons](https://github.com/Eduard9969/blade-polaris-icons) by [Samoilenko Eduard](https://github.com/Eduard9969)
- [Blade Prime Icons](https://github.com/codeat3/blade-prime-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Radix Icons](https://github.com/codeat3/blade-radix-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Remix Icon](https://github.com/andreiio/blade-remix-icon) by [Andrei Ioniță](https://github.com/andreiio)
- [Blade RPG Awesome Icons](https://github.com/codeat3/blade-rpg-awesome-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Simple Icons](https://github.com/ublabs/blade-simple-icons) by [Adrián UB](https://github.com/adrian-ub)
- [Blade Simple Line Icons](https://github.com/codeat3/blade-simple-line-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Solar Icons](https://github.com/codeat3/blade-solar-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade System UIcons](https://github.com/codeat3/blade-system-uicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Tabler Icons](https://github.com/ryangjchandler/blade-tabler-icons) by [Ryan Chandler](https://github.com/ryangjchandler)
- [Blade Teeny Icons](https://github.com/codeat3/blade-teeny-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Typicons](https://github.com/codeat3/blade-typicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Uiw Icons](https://github.com/codeat3/blade-uiw-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Unicons](https://github.com/codeat3/blade-unicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade UntitledUI Icons](https://github.com/mckenziearts/blade-untitledui-icons) by [Arthur Monney](https://github.com/mckenziearts)
- [Blade Vaadin Icons](https://github.com/codeat3/blade-vaadin-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade VSCode Codicons](https://github.com/codeat3/blade-codicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Weather Icons](https://github.com/codeat3/blade-weather-icons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)
- [Blade Zondicons](https://github.com/blade-ui-kit/blade-zondicons) by [Swapnil Sarwe](https://github.com/swapnilsarwe)

## Requirements

- PHP 7.4 or higher
- Laravel 8.0 or higher

## Installation

Install the package with composer:

```bash
composer require blade-ui-kit/blade-icons
```

Then, publish the configuration and **uncomment** the `default` icon set:

```bash
php artisan vendor:publish --tag=blade-icons
```

Make sure that the path defined for this icon set exists. By default it's `resources/svg`. Your SVG icons will need to be placed in this directory.

## Upgrading

Please refer to [`the upgrade guide`](UPGRADE.md) when upgrading the library.

## Caching

When working with Blade Icons, and third party icon sets in particular, you'll often be working with large icon sets. This can slow down your app tremendously, especially when making use of [Blade components](#components). To solve this issue, Blade Icons ships with caching support. To enable icon caching you can run the following command:

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

Also, when adding new icons, renaming directories in your icon paths, it's always a good idea to clear your views before refreshing the page:

```bash
php artisan view:clear
```

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

> [!WARNING]  
> Always make sure you're pointing to existing directories.

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

> [!WARNING]
> When using multiple paths instead of one, Blade Icons will return the first icon it finds when an icon name is present in more than one path. Please ensure you use unique icon names when registering multiple paths if you want to retrieve the correct icon.

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
    'fallback' => 'heroicon-cake',
];
```

> [!NOTE]
> There's one caveat when using fallback icons and that is that they don't work when using [Blade Components](#components). In this case, Laravel will throw an exception that the component cannot be found. If you want to make use of fallback icons please consider one of the other usages.

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

The sequence in which classes get applied is `default attributes / set attributes / explicit attributes` where the latter overwrites the former. It is not possible to overwrite existing attributes on SVG icons. If you already have attributes defined on icons which you want to override, remove them first.

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

> [!NOTE]
> With Blade components, using a prefix is always required, even when referencing icons from the default set.

#### Deferring icons

When you're using the same icon in lots of places on the page the DOM element count may explode upwards.
To remedy this you can add the defer attribute to the components:

```blade
<x-icon-camera defer />
```

This will push the icons to the stack "bladeicons", you should load this stack at the bottom of your page

```blade
   ...
    <svg hidden class="hidden">
        @stack('bladeicons')
    </svg>
</body>
</html>
```

> [!WARNING]
> Deferring icons is only possible using the `<x-icon>` component. This [feature doesn't work](https://github.com/blade-ui-kit/blade-icons/issues/194#issuecomment-1175156423) with the `@svg` Blade directive or the `svg()` helper function.

##### Using deferred icons in JavaScript

You can re-use your icons from blade in your JavaScript rendered views by providing a custom defer value that will be used as an identifier:

```blade
<x-icon-camera defer="my-custom-hash" />
```

Then, in your JavaScript, create an `svg` element with `use` and `href="#icon-{your-hash}"` attribute.

```javascript
function icon() {
    return <svg><use href="#icon-my-custom-hash"></use></svg>
}
```

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

Although they're enabled by default, if you don't wish to use components at all you may choose to disable them completely by setting the `components.disabled` setting in your `blade-icons.php` config file to `true`:

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

### Accessibility

If the icon should have semantic meaning, a text alternative can be added with the title attribute. Refer to the [Usage](https://github.com/blade-ui-kit/blade-icons#usage) section of this documentation to learn how to add an attribute.

For almost all use cases, your icon will be assuming the role of an image. This means that deciding on if your icon has any semantic meaning, or what that semantic meaning is, you can use the [WCAG alt text decision tree](https://www.w3.org/WAI/tutorials/images/decision-tree/).

If your icon has semantic meaning, using the title attribute will apply the following features to the SVG element:

- Child element of `<title>` with a unique ID containing the value that was passed
- `title` attribute containing the value that was passed
- `role="img"`
- `aria-labelledby` to refer to the unique ID of the title element

Example usage:

```blade
<x-icon-camera title="camera" />

@svg('camera', ['title' => 'camera'])
```

Example result:

```html
<svg 
	 title="Camera" 
	 role="img" 
	 xmlns="http://www.w3.org/2000/svg"
	 viewBox="0 0 448 512"
>
	<title>
		Camera
	</title>
	<path fill="currentColor" d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"></path>
</svg>  
```

If your icon does not have semantic meaning, you may want to hide the icon to reduce overall document clutter. You may do this by adding `aria-hidden="true"` to your icon.

## Building Packages

If you're interested in building your own third party package to integrate an icon set, it's pretty easy to do so. We've created [a template repo for you to get started with](https://github.com/blade-ui-kit/blade-icons-template). You can find the getting started instructions in its readme.

If you want to learn how to create packages we can recommend these two excellent courses:

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

### Generating Icons

Blade Icons also offers an easy way to generate icons for your packages. By defining a config file with predefined source and destination paths, you can make updating your icons a breeze.

First, start off by creating a `generation.php` config file in the `config` directory of your icon package. Next, you can define an array per icon set that you want to generate. Below is a full version of this file with explanation for every option. Only the `source` and `destination` options are required.

```php
<?php

use Symfony\Component\Finder\SplFileInfo;

return [
    [
        // Define a source directory for the sets like a node_modules/ or vendor/ directory...
        'source' => __DIR__.'/../node_modules/heroicons/outline',

        // Define a destination directory for your icons. The below is a good default...
        'destination' => __DIR__.'/../resources/svg',

        // Strip an optional prefix from each source icon name...
        'input-prefix' => 'o-',

        // Set an optional prefix to applied to each destination icon name...
        'output-prefix' => 'o-',

        // Strip an optional suffix from each source icon name...
        'input-suffix' => '-o',

        // Set an optional suffix to applied to each destination icon name...
        'output-suffix' => '-o',

        // Enable "safe" mode which will prevent deletion of old icons...
        'safe' => true,

        // Call an optional callback to manipulate the icon with the pathname of the icon,
        // the settings from above and the original icon file instance...
        'after' => static function (string $icon, array $config, SplFileInfo $file) {
            // ...
        },
    ],

    // More icon sets...
];
```

See [an example `config/generation.php` file](https://github.com/blade-ui-kit/blade-heroicons/blob/main/config/generation.php) for the Heroicons package.

After setting up your config file you can use the icon generation as follow from the root of your icon package directory:

```zsh
vendor/bin/blade-icons-generate
```

## Changelog

Check out the [CHANGELOG](CHANGELOG.md) in this repository for all the recent changes.

## Maintainers

Blade Icons is developed and maintained by [Dries Vints](https://driesvints.com).

## License

Blade Icons is open-sourced software licensed under [the MIT license](LICENSE.md).
