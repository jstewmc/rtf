# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Changed

- Updated from PHPUnit version 4 to version 9.
- Added continuous integration with [CircleCI](https://circleci.com/gh/jstewmc/rtf).
- Added code coverage analysis with [CodeCov](https://codecov.io/gh/jstewmc/rtf).
- Added [slevomat/coding-standard](https://github.com/slevomat/coding-standard) to enforce coding standards.
- Extend `jstewmc/stream` with custom methods to make lexing easier.
- Modernize the Lexing and Parsing classes (i.e., type hints, smaller methods, guard clauses, etc).

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
