# Upgrade Guide

General steps for every update:

- Run `php artisan view:clear`

## Upgrading from v0.3.4 to 0.4.0

0.4.0 is a complete rewrite. If you haven't yet, [read the announcement pr](https://github.com/adamwathan/blade-svg/pull/50). The package has been rewritten from the ground up and the public API has drastically changed. Most notable is the added support for Blade component syntax. While it'd be impossible to reference to every single breaking change, please refer below for the most notable ones:

### Package Renaming

**The package has been renamed to Blade Icons.** For now, it'll keep the `nothingworks/blade-svg` composer package name but it'll be renamed to a new name before we tag 0.4.0 and it'll be moved to a new organisation. More news on that as soon as the 0.4.0 beta period has ended.

### Minimum Requirements

The package now requires as a minimum:

- PHP 7.2
- Laravel 7.6

### Config Changes

Blade Icons now supports multiple icon sets. This is useful for third party packages that offer different icon sets and allow for apps to make use of different icons from different sets in the same app. As such, the config file has been changed drastically. It's best that you re-publish it using the command below:

```bash
php artisan vendor:publish --tag=blade-icons --force
```

This will publish the config as `blade-icons.php`. You should remove the old `blade-svg.php` config file.

The new config file defines a new `sets` config option which is an associative array with different sets. It ships with a `default` set which you should use for your own app. You can add as many different sets as you like. For a full list of options please [refer to the docs](README.md#configuration). 

#### Inline Option

The `inline` config option has been removed. You should now always directly use the `@svg` or `@sprite` directives to render either an inline icon or a sprite icon.

```blade
// Before...
{{ svg_image('cog', 'icon icon-lg')->inline() }}
{{ svg_image('cog', 'icon icon-lg')->sprite() }}

// After...
@svg('cog', 'icon icon-lg')
@sprite('cog', 'icon icon-lg')
```

### Helper Renames

The `svg_image() helper has been renamed to `svg()`. Consequently, the `svg_spritesheet()` helper has been renamed to `sprite_sheet()`.
