# Changelog

This changelog follows [the Keep a Changelog standard](https://keepachangelog.com).


## [Unreleased](https://github.com/blade-ui-kit/blade-icons/compare/1.0.0...main)


## [1.0.0 (2021-03-21)](https://github.com/blade-ui-kit/blade-icons/compare/0.5.1...1.0.0)

### Added
- Default Icon class ([#110](https://github.com/blade-ui-kit/blade-icons/pull/110))
- Filesystem Disks ([#111](https://github.com/blade-ui-kit/blade-icons/pull/111))
- Fallback icons ([#112](https://github.com/blade-ui-kit/blade-icons/pull/112))
- Multiple paths per icon set ([#113](https://github.com/blade-ui-kit/blade-icons/pull/113))
- Default attributes ([#115](https://github.com/blade-ui-kit/blade-icons/pull/115))
- Allow to disable components ([#118](https://github.com/blade-ui-kit/blade-icons/pull/118))
- Caching ([#121](https://github.com/blade-ui-kit/blade-icons/pull/121))

### Changed
- Strip XML tag from icon ([#116](https://github.com/blade-ui-kit/blade-icons/pull/116))
- Drop Laravel 7 support ([#117](https://github.com/blade-ui-kit/blade-icons/pull/117))
- Drop PHP 7.3 ([#123](https://github.com/blade-ui-kit/blade-icons/pull/123))


## [0.5.1 (2020-11-05)](https://github.com/blade-ui-kit/blade-icons/compare/0.5.0...0.5.1)

### Fixed
- Ignore files without SVG extension ([#103](https://github.com/blade-ui-kit/blade-icons/pull/103))


## [0.5.0 (2020-10-31)](https://github.com/blade-ui-kit/blade-icons/compare/0.4.5...0.5.0)

### Added
- PHP 8 Support ([#101](https://github.com/blade-ui-kit/blade-icons/pull/101))

### Removed
- Drop PHP 7.2 support ([b36f216](https://github.com/blade-ui-kit/blade-icons/commit/b36f216c03f096cd59cc8b1ebfa41a926bfe8e78))

### Fixed
- Strip trailing slash from path ([#88](https://github.com/blade-ui-kit/blade-icons/pull/88))


## [0.4.5 (2020-09-04)](https://github.com/blade-ui-kit/blade-icons/compare/0.4.4...0.4.5)

### Added
- Laravel 8 support ([#87](https://github.com/blade-ui-kit/blade-icons/pull/87))


## [0.4.4 (2020-08-14)](https://github.com/blade-ui-kit/blade-icons/compare/0.4.3...0.4.4)

### Fixed
- Fix in-memory cache of multiple icon sets ([#74](https://github.com/blade-ui-kit/blade-icons/pull/74))


## [0.4.3 (2020-07-09)](https://github.com/blade-ui-kit/blade-icons/compare/0.4.2...0.4.3)

### Fixed
- Properly register `callAfterResolving` callback ([bdd6e59](https://github.com/blade-ui-kit/blade-icons/commit/bdd6e59980caa63865da6ce82ed2590c26790efd))


## [0.4.2 (2020-06-27)](https://github.com/blade-ui-kit/blade-icons/compare/0.4.1...0.4.2)

### Fixed
- Revert uncomment of default set ([62357bc](https://github.com/blade-ui-kit/blade-icons/commit/62357bc45cff8e78ec8cdda96581574fc85503fe))


## [0.4.1 (2020-06-27)](https://github.com/blade-ui-kit/blade-icons/compare/0.4.0...0.4.1)

### Changed
- Use singleton for factory ([5e69d60](https://github.com/blade-ui-kit/blade-icons/commit/5e69d6075e2e2a4204d172d36a6864b32f9014dc))
- Uncomment default set ([a928be4](https://github.com/blade-ui-kit/blade-icons/commit/a928be4d544e1c53ecc459c2971e3fd68f7def49))
- Refactor component registration ([e7c20c7](https://github.com/blade-ui-kit/blade-icons/commit/e7c20c730ba6bb929cbe246cfca7aea0834742af))

### Fixed
- Fix bug with component classes ([d53025a](https://github.com/blade-ui-kit/blade-icons/commit/d53025a1ad573f7c16e822aeca44e42127df463d))


## [0.4.0 (2020-06-17)](https://github.com/blade-ui-kit/blade-icons/compare/0.3.4...0.4.0)

Refactor to Blade Icons. See the [upgrade guide](https://github.com/blade-ui-kit/blade-icons/blob/main/UPGRADE.md#upgrading-from-v034-to-040) for relevant upgrade notes.
