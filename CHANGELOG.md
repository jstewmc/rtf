# Changelog

## 0.2.0 - March 23, 2015

* Update lexing methods to use [character streams](https://github.com/jstewmc/stream) instead of character arrays:
  * Replace `Token\Text::createFromSource()` with `createFromStream()`
  * Replace `Token\Control\Word::createFromSource()` with `createFromStream()`
  * Replace `Token\Control\Symbol::createFromSource()` with `createFromStream()`
  * Update `Lexer::lex()` to use accept instance of `Jstewmc\Stream\Stream` as argument instead of string

## 0.1.0 - March 10, 2015

The initial release.

[API Documentation](http://jstewmc.github.io/rtf/api/0.1.0/)