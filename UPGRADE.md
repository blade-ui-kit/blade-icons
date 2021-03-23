# Upgrade Guide

General steps for every update:

- Run `php artisan icons:clear`
- Run `php artisan view:clear`

If you published the config file, make sure to sync it with the config file from the version you're upgrading to.

## Upgrading from 0.5.1 to 1.0.0

Blade Icons 1.0.0 is the first major release of the library. This release brings a whole range of new features and a stable API. While there aren't many, there's a few breaking changes to know about.

### Minimum Requirements

The package now requires as a minimum:

- PHP 7.4
- Laravel 8.0

### Default Icon Component

PR: https://github.com/blade-ui-kit/blade-icons/pull/110

Blade Icons 1.0.0 ships with a default `Icon` component. If you were already using a default icon component with the `<x-icon` syntax then you can either upgrade to the Blade Icons one or disable the default shipped component by setting it to `null` in the config file:

```php
<?php

return [
    'components' => [
        'default' => null,
    ],
];
```

### XML Tags

PR: https://github.com/blade-ui-kit/blade-icons/pull/116

Blade Icons 1.0.0 will now automatically strip XML tags from SVG icons. These should not be needed to render SVG icons. If you were specifically relying on these XML tags to be output together with the SVG contents you may not want to upgrade.


## Upgrading from 0.3.4 to 0.4.0

0.4.0 is a complete rewrite. If you haven't yet, [read the announcement pr](https://github.com/blade-ui-kit/blade-icons/pull/50). The package has been rewritten from the ground up and the public API has drastically changed. Most notable is the added support for Blade component syntax. While it'd be impossible to reference to every single breaking change, please refer below for the most notable ones:

### Package Renaming

**The package has been renamed to Blade Icons.** It's also been moved to the Blade UI Kit organisation. You should update your reference in your `composer.json` to `blade-ui-kit/blade-icons`.

### Minimum Requirements

The package now requires as a minimum:

- PHP 7.2
- Laravel 7.14

### Config Changes

Blade Icons now supports multiple icon sets. This is useful for third party packages that offer different icon sets and allow for apps to make use of different icons from different sets in the same app. As such, the config file has been changed drastically. It's best that you re-publish it with the command below:

```bash
php artisan vendor:publish --tag=blade-icons --force
```

This will publish the config as `blade-icons.php`. You should remove the old `blade-svg.php` config file.

The new config file defines a new `sets` config option which is an associative array with different sets. It ships with a `default` set which you should use for your own app. You can add as many sets as you like. For a full list of options please [refer to the docs](README.md#configuration). 

### Sprite Sheets Removed

All functionality concerning sprite sheets have been removed. We felt that sprite sheets weren't really used that much anymore. We recommend using individual icon SVG files instead.

### Helper Renames

The `svg_image()` helper has been renamed to `svg()`.

### Prefixes

The new release introduces the concept of prefixes in your config file. If you want to continue to use your current icon set and were prefixing your icons like `icon-cloud.svg` it's best that you set the prefix in your config file and remove the prefix from your icons themselves. Otherwise you can run into unexpected name resolving issues.
