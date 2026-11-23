# Changelog

## 0.1.0 (2026-11-23)

### ⚠ BREAKING CHANGES

* The IdealPostcodes\Resources bindings and the facade's resource methods are removed; call operations on the client or facade directly, such as IdealPostcodes::postcodes('BR8 7RE').

### refactor

* Bind only the client and mix it into the facade

### Features

* Add the Laravel package (ideal-postcodes/laravel)
* Add the PHP version to the User-Agent
* Send both keys as Authorization: Bearer

### Bug Fixes

* Keep the package and SDK identifiers beside a configured User-Agent

## Changelog
