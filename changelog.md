# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.3] - 2020-03-05
### Added
* `changelog.md` file.

## [1.0.2] - 2020-03-05
### Fixed
* required PHP version in `composer.json`.

## [1.0.1] - 2020-03-05
### Fixed
* `access-back-office` gate now allows users with `manage_back_office` permissions.

## [1.0] - 2020-03-05 - Support of Laravel `6.x`
### Changed
* `CommonAccessors::getUrlFor()` - fixed usage deprecated helpers.
* `RouteServiceProvider::bindModelName()` - fixed usage deprecated helpers.
* refactor return & use statements.
* restrict required PHP version `7.0 - 7.3`.
