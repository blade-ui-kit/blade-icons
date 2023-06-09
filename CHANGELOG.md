# Changelog

This changelog follows [the Keep a Changelog standard](https://keepachangelog.com).

## [Unreleased](https://github.com/blade-ui-kit/blade-icons/compare/1.5.2...1.x)

## [1.5.2](https://github.com/blade-ui-kit/blade-icons/compare/1.5.1...1.5.2) - 2023-06-09

- Windows support by @driesvints in https://github.com/blade-ui-kit/blade-icons/pull/213

## [1.5.1](https://github.com/blade-ui-kit/blade-icons/compare/1.5.0...1.5.1) - 2023-02-15

- Apply SVG file filter for Generator by Default by @mallardduck in https://github.com/blade-ui-kit/blade-icons/pull/209

## [1.5.0](https://github.com/blade-ui-kit/blade-icons/compare/1.4.1...1.5.0) - 2023-01-11

### Added

- Laravel v10 Support by @driesvints in https://github.com/blade-ui-kit/blade-icons/pull/207

## [1.4.1](https://github.com/blade-ui-kit/blade-icons/compare/1.4.0...1.4.1) - 2022-09-30

### Fixed

- Fixed deferred SVGs that use mask, defs or use tags by @AEM5299 in https://github.com/blade-ui-kit/blade-icons/pull/202

## [1.4.0](https://github.com/blade-ui-kit/blade-icons/compare/1.3.2...1.4.0) - 2022-09-28

### Added

- Add ability to provide own defer hash by @pionl in https://github.com/blade-ui-kit/blade-icons/pull/201

## [1.3.2](https://github.com/blade-ui-kit/blade-icons/compare/v1.3.1...1.3.2) - 2022-09-21

### Fixed

- Fix SVGs that are using `<g` by @pionl in https://github.com/blade-ui-kit/blade-icons/pull/200

## [v1.3.1](https://github.com/blade-ui-kit/blade-icons/compare/1.3.0...v1.3.1) - 2022-08-24

### Changed

- Prioritize component attributes over set and default attributes by @sebastianpopp in https://github.com/blade-ui-kit/blade-icons/pull/197

## [1.3.0](https://github.com/blade-ui-kit/blade-icons/compare/1.2.2...1.3.0) - 2022-05-11

### Added

- Defer icons to icons stack to reduce DOM count by @indykoning in https://github.com/blade-ui-kit/blade-icons/pull/191

## [1.2.2](https://github.com/blade-ui-kit/blade-icons/compare/v0.3.5...1.2.2) - 2022-02-28

### Security

- Fix XSS injection ([bf972cb](https://github.com/blade-ui-kit/blade-icons/commit/bf972cb55ba65955a9735a0625af4928db7e3373))

## [v0.3.5](https://github.com/blade-ui-kit/blade-icons/compare/1.2.1...v0.3.5) - 2022-02-28

### Security

- Fix XSS injection ([bf972cb](https://github.com/blade-ui-kit/blade-icons/commit/bf972cb55ba65955a9735a0625af4928db7e3373))

## [1.2.1](https://github.com/blade-ui-kit/blade-icons/compare/1.2.0...1.2.1) - 2022-02-20

### Security

- Fix XSS injection vulnerability ([f954c3f](https://github.com/blade-ui-kit/blade-icons/commit/f954c3f6518f9883f2d0c534f43c3767d063ad13))

## [1.2.0 (2022-01-20)](https://github.com/blade-ui-kit/blade-icons/compare/1.1.2...1.2.0)

### Changed

- Laravel 9 support ([#183](https://github.com/blade-ui-kit/blade-icons/pull/183))

## [1.1.2 (2021-08-11)](https://github.com/blade-ui-kit/blade-icons/compare/1.1.1...1.1.2)

### Changed

- Make original file available in icon generation callback ([#173](https://github.com/blade-ui-kit/blade-icons/pull/173))

## [1.1.1 (2021-06-29)](https://github.com/blade-ui-kit/blade-icons/compare/1.1.0...1.1.1)

### Changed

- New suffix options ([#166](https://github.com/blade-ui-kit/blade-icons/pull/166))

## [1.1.0 (2021-06-25)](https://github.com/blade-ui-kit/blade-icons/compare/1.0.2...1.1.0)

### Added

- Add icon generation for package maintainers ([#144](https://github.com/blade-ui-kit/blade-icons/pull/144))

## [1.0.2 (2021-04-03)](https://github.com/blade-ui-kit/blade-icons/compare/1.0.1...1.0.2)

### Fixed

- Fix if statement ([7829b0b](https://github.com/blade-ui-kit/blade-icons/commit/7829b0b4faacd9cab1ddac8dcf48e5eb12a2b2b1))

## [1.0.1 (2021-03-31)](https://github.com/blade-ui-kit/blade-icons/compare/1.0.0...1.0.1)

### Fixed

- Fix an issue with empty disk ([2505ea4](https://github.com/blade-ui-kit/blade-icons/commit/2505ea41eccb72933497213c12e6d041add7b844))

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
