# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.5.2] - 2021-11-12

### Added

- Added support for parsing font tables (but not support for styling fonts yet).
- Added support for parsing color tables (but not support for styling colors yet).
- Added support for parsing stylesheets (but not support for styles yet).

### Changed

- Moved character sets, font family, and special character control words into sub-directories.
- Updated the `Parse\ControlWord` service to detect control word sub-types and constructor arguments automatically.

### Fixed

- Fixed [#11](https://github.com/jstewmc/rtf/issues/11), where the conversion of an RTF document to plain text output the text in the header's font table, color table, and stylesheets too.

## [0.5.1] - 2021-11-06

### Added

- Added support for document encoding. If a document defines a character set (i.e., `\pc`, `\pca`, `\mac`) or it defines the `\ansi` character set and a code page (e.g., `\ansicpg1252`), this library will use that character encoding to render non-ASCII characters.

### Fixed

- Fixed issue parsing apostrophe control symbol, where a conditional was using the wrong symbol name.
- Fixed issue parsing other tokens, where they caused a variable-not-defined exception to be thrown during parsing.
- Fixed [#2](https://github.com/jstewmc/rtf/issues/2), where the `Apostrophe` control symbol did not work correctly.

## [0.5.0] - 2021-11-04

### Added

- Added support for PHP 7.4 and 8.0.
- Added continuous integration with [CircleCI](https://circleci.com/gh/jstewmc/rtf).
- Added code coverage analysis with [CodeCov](https://codecov.io/gh/jstewmc/rtf).
- Added coding standards with [slevomat/coding-standard](https://github.com/slevomat/coding-standard).
- Added vulnerability checking with [roave/security-advisories](https://github.com/Roave/SecurityAdvisories).

### Changed

- Modernized the library (i.e., add type hints, refactor big methods, move to services, add guard clauses, etc).
- Updated test suite from PHPUnit version 4 to version 9.
- Extended `jstewmc/stream` with custom methods to make lexing easier.

### Fixed

- Fixed [#1](https://github.com/jstewmc/rtf/issues/1), where the classnames in this library's PHPDoc comments were incorrect and prevented IDE code completion.
- Fixed [#3](https://github.com/jstewmc/rtf/issues/3), where installation instructions were missing from this library's README.


## [0.4.3] - 2015-08-17

* Fix `\cxds` control word. The `\cxds` control word should glue two words together without a space between them. However, up to now, it only deleted the previous space, not the spaces to either side.

## [0.4.2] - 2015-08-12

* Add check for mismatched group-open and group-close tokens to `Parser`

## [0.4.1] - 2015-08-11

* Fix logic error in `Snippet` class

## [0.4.0] - 2015-08-10

* Add `Snippet` class

## [0.3.0] - 2015-07-06

* Add RTF-CRE control words

## [0.2.0] - 2015-07-06

* Update `Document::read()` and `Document::load()` to use [Jstewmc\Chunker](https://github.com/jstewmc/chunker).
* Update lexing methods to use [Jstewmc\Stream](https://github.com/jstewmc/stream) instead of character arrays:
  * Replace `Token\Text::createFromSource()` with `createFromStream()`
  * Replace `Token\Control\Word::createFromSource()` with `createFromStream()`
  * Replace `Token\Control\Symbol::createFromSource()` with `createFromStream()`
  * Update `Lexer::lex()` to use accept instance of `Jstewmc\Stream\Stream` as argument instead of string

## [0.1.0] - 2015-03-10

Initial release
