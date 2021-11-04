[![CircleCI](https://circleci.com/gh/jstewmc/rtf.svg?style=svg)](https://circleci.com/gh/jstewmc/rtf) [![codecov](https://codecov.io/gh/jstewmc/rtf/branch/master/graph/badge.svg?token=kPPlLgbhd3)](https://codecov.io/gh/jstewmc/rtf)

# rtf
This library makes it easy to work with (RTF) documents in PHP.

```php
use Jstewmc\Rtf\{Document, Element};

$document = new Document('{\b foo\b0}');

$document
	->getRoot()         // get the document's root group
	->getFirstChild()   // get the "\b" control word element
	->getNextSibling()  // get the "foo" text element
	->setText('bar');   // replace "foo" with "bar"

echo $document;
```

The example above would produce the following output (note, the text `"foo"` has been replaced by the text `"bar"`):

```
{\b bar\b0}
```

## Installing

This library requires [PHP 7.4+](https://secure.php.net).

It is multi-platform, and we strive to make it run equally well on Windows, Linux, and OSX.

It should be installed via [Composer](https://getcomposer.org). To do so, add the following line to the `require` section of your `composer.json` file, and run `composer update`:

```javascript
{
   "require": {
       "jstewmc/rtf": "^0.5"
   }
}
```

## Using this library

This library is large, and it's challenging to briefly summarize it. To make things a bit easier to understand, we've broken it into [reading](#reading-rtf), [writing](#writing-rtf), [saving](#saving-rtf), [traversing](#traversing-rtf), [editing](#editing-rtf), and [styling](#styling-rtf) RTF.

### Reading RTF

You can construct an RTF _document_ from a string or file:

```php
use Jstewmc\Rtf\Document;

$document1 = new Document('{\b foo\b0}');

$document2 = new Document('/path/to/file.rtf');
```

You can construct an RTF _snippet_ from a string:

```php
use Jstewmc\Rtf\Snippet;

$snippet = new Snippet('\cxds ing');
```

Either way, the library will automatically lex, parse, and render the given RTF.

### Writing RTF

You can use the `write()` method to output a document or snippet as an RTF, HTML, or plain-text string:

```php
use Jstewmc\Rtf\{Document, Snippet};

$document = new Document('{\b foo\b0}');

echo $document->write();        // prints "{\b foo\b0}"
echo $document->write('rtf');   // prints "{\b foo\b0}"
echo $document->write('text');  // prints "foo"
echo $document->write('html');  // prints "<section style=""><p style="">..."

$snippet = new Snippet('\cxds ing');

echo $snippet->write();        // prints "\cxds ing"
echo $snippet->write('rtf');   // prints "\cxds ing"
echo $snippet->write('text');  // prints ""
echo $snippet->write('html');  // prints ""
```

When a document or snippet is treated as a string, it will return an RTF string:

```php
use Jstewmc\Rtf\{Document, Snippet};

$document = new Document('{\b foo\b0}');

echo $document;           // prints "{\b foo\b0}"
echo (string) $document;  // prints "{\b foo\b0}"
echo ''.$document;        // prints "{\b foo\b0}"

$snippet = new Snippet('\cxds ing');

echo $snippet;           // prints "\cxds ing"
echo (string)$snippet;   // prints "\cxds ing"
echo ''.$snippet;        // prints "\cxds ing"
```

### Saving RTF

You can use a document's `save()` method to save a document to a file (snippets don't support files):

```php
use Jstewmc\Rtf\Document;

$document = new Document('{\b foo\b0}');

$document->save('/path/to/file.txt');   // puts contents "foo"
$document->save('/path/to/file.rtf');   // puts contents "{\b foo\b0}"
$document->save('/path/to/file.html');  // puts contents "<section style="">..."
```

By default, the `save()` method will assume the file's format from the destination's file extension (i.e., `htm[l]`, `rtf`, and `txt`). If you use a non-standard file extension, you can specify the file's format as the method's second argument:

```php
use Jstewmc\Rtf\Document;

$document = new Document('{\b foo\b0}');

$document->save('/path/to/file.foo', 'text');  // puts contents "foo"
```

### Traversing RTF

Documents and snippets are composed of RTF _elements_, much like an HTML document is composed of tags or an XML document is composed of nodes. There are four types of RTF elements: groups, control words, control symbols, and text. To traverse a document or snippet, you'll move between and among these elements.

Each element is represented by a PHP object within the `Jstewmc\Rtf\Element` namespace.

* Group and text elements are represented by generic objects, `Element\Group` and `Element\Text`, respectively.
* _Supported_ control word and control symbol elements are represented by specific objects (e.g., the bold control word, `\b`, corresponds to the `Element\Control\Word\B` element, and the asterisk control symbol, `\*`, corresponds to the `Element\Control\Symbol\Asterisk` element).
* _Unsupported_ control word and control symbol elements are represented by generic objects, `Element\Control\Word` and `Element\Control\Symbol`, respectively.

Groups are a bit special, because they are the only element in RTF that can have children.

Every _document_ has a root group, the top-most element of a document. All other elements in an RTF document are descendants of this group. Traversing a document always starts from the root group:

```php
use Jstewmc\Rtf\Document;

$document = new Document('{\b foo\b0}');

$document->getRoot()->getFirstChild();  // returns the "\b " control word
```

A _snippet_, on the other hand, may not have a root group. For a variety of reasons, this library treats a snippet as its own root group:

```php
use Jstewmc\Rtf\Snippet;

$snippet = new Snippet('\cxds ing');

$snippet->getFirstChild();  // returns the "\cxds " control word
```

A group - root or not - provides a variety of methods to traverse its child elements, which may or may not include other groups.

You can use `getFirstChild()`, `getLastChild()`, or `getChild()` to access the first, last, or any child:

```php
use Jstewmc\Rtf\Document;

$document = new Document('{\b foo\b0}');

$root = $document->getRoot();

$root->getFirstChild();  // returns the "\b" control word
$root->getLastChild();   // returns the "\b0" control word
$root->getChild(1);      // returns the "foo" text element
```

You can use `getControlWords()` or `getControlSymbols()` to query for specific control words and symbols (the second argument, `parameter`, may be: `null`, any parameter (default); `false`, no parameter; or, an `int`/`string`):

```php
use Jstewmc\Rtf\Document;

$document = new Document('{\b foo\b0}');

$root = $document->getRoot();

$group->getControlWords('b');         // returns "\b" and "\b0" control words
$group->getControlWords('b', 0);      // returns the "\b0" control word
$group->getControlWords('b', false);  // returns the "\b" control word
```

You can use the `hasChild()` method to query whether or not an element exists:

```php
use Jstewmc\Rtf\{Document, Element\Text};

$document = new Document('{\b foo\b0}');

$root = $document->getRoot();

$root->hasChild(0);    // returns true
$root->hasChild(999);  // returns false

$root->hasChild(new Text('foo'));  // returns true
$root->hasChild(new Text('bar'));  // returns false

$root->hasChild(new Text('foo'), 0);  // returns false
$root->hasChild(new Text('foo'), 1);  // returns true
$root->hasChild(new Text('bar'), 0);  // returns false
```

While the examples above use the root group, any group element supports these methods. But, there's more to traversing elements than just groups.

You can use `getNextSibling()` and `getPreviousSibling()` to move through any element:

```php
use Jstewmc\Rtf\Document;

$document = new Document('{\b foo\b0}');

$root = $document->getRoot();

$b   = $root->getFirstChild();  // returns the "\b" control word
$foo = $b->getNextSibling();    // returns the "foo" text element
$b0  = $foo->getNextSibling();  // returns the "\b0" control word

$foo === $b0->getPreviousSibling();  // returns true
$b === $foo->getPreviousSibling();   // returns true
```

You can use `getNextText()` and `getPreviousText()` to move through text elements:

```php
use Jstewmc\Rtf\Document;

$document = new Document('{\b foo\b0 bar\i baz\i0}');

$root = $document->getRoot();

$b   = $root->getFirstChild();  // returns the "\b" control word
$foo = $b->getNextText();       // returns the "foo" text element
$bar = $b->getNextText();       // returns the "bar" text element
$baz = $b->getNextText();       // returns the "baz" text element

$bar === $baz->getPreviousSibling();  // returns true
$foo === $bar->getPreviousSibling();  // returns true
```

### Editing RTF

This library includes a number of methods for editing RTF.

We've done our best to support editing elements from either side of the parent-child, `Group`-`Element` relationship. So, feel free to use whichever side makes the most sense given the element you currently have and the change you're attempting to make.

You can use `Group::appendChild()` or `Element::appendTo()` to append an element as the last child to a group:

```php
use Jstewmc\Rtf\{Document, Element\Text};

$document = new Document('{\b foo\b0}');

$bar = new Text('bar');

$document->getRoot()->appendChild($bar);

echo $document;  // prints "{\b foo\b0 bar}"

$bar->appendTo($document->getRoot());

echo $document;  // prints "{\b foo\b0 barbar}"
```

You can use `Group::prependChild()` or `Element::prependTo()` to prepend an element as the first child to a group:

```php
use Jstewmc\Rtf\{Document, Element\Text};

$document = new Document('{\b foo\b0}');

$bar = new Text('bar');

$document->getRoot()->prependChild($bar);

echo $document;  // prints "{bar\b foo\b0}"

$bar->prependTo($document->getRoot());

echo $document;  // prints "{barbar\b foo\b0}"
```

You can use `Group::insertChild()`to insert an element at a given index within a group:

```php
use Jstewmc\Rtf\{Document, Element\Text};

$document = new Document('{\b foo\b0}');

$bar = new Text('bar');

$document->getRoot()->insertChild($bar, 1);

echo $document;  // prints "{\b barfoo\b0}"
```

You can use `Element::insertBefore()` or `Element::insertAfter()` to insert the current element before or after another element, respectively:

```php
use Jstewmc\Rtf\{Document, Element\Text};

$document = new Document('{\b foo\b0}');

$bar = new Text('bar');

$foo = $document->getRoot()->getChild(1);  // returns the "foo" text element

$bar->insertAfter($foo);

echo $document;  // prints "{\b foobar\b0}"

$bar->insertBefore($foo);

echo $document;  // prints "{\b barfoobar\b0}"
```

You can use `Element::putPreviousSibling()` or `Element::putNextSibling()` to insert an element before or after the current element, respectively:

```php
use Jstewmc\Rtf\{Document, Element\Text};

$document = new Document('{\b foo\b0}');

$bar = new Text('bar');

$foo = $document->getRoot()->getChild(1);  // returns the "foo" text element

$foo->putNextSibling($bar);

echo $document;  // prints "{\b foobar\b0}"

$foo->putPreviousSibling($bar);

echo $document;  // prints "{\b barfoobar\b0}"
```

You can use `Group::replaceChild()` or `Element::replaceWith()` to replace an element:

```php
use Jstewmc\Rtf\{Document, Element\Text};

$document = new Document('{\b foo\b0}');

$bar = new Text('bar');

$document->getRoot()->replaceChild(1, $bar);

echo $document;  // prints "{\b bar\b0}"

$baz = new Text('baz');

$document->getRoot()->getChild(1)->replaceWith($baz);

echo $document;  // prints "{\b baz\b0}"
```

Finally, you can use `Group::removeChild()` to remove an element:

```php
use Jstewmc\Rtf\{Document, Element\Text};

$document = new Document('{\b foo\b0}');

$document->getRoot()->removeChild(1);

echo $document;  // prints "{\b \b0}"
```

### Styling RTF

The RTF specification lumps an element's style into one huge "group state". Such a monolithic state is difficult to work with, however. So, I gave each element a style property, like an HTML element.

An element's style is sub-divided into document-, section-, paragraph-, and character-states.

For any element, the following properties are available:

* Character-state
  * `isBold` - a flag indicating whether or not the element is bold (defaults to false)
  * `isItalic` - a flag indicating whether or not the element is italic (defaults to false)
  * `isStrikethrough` - a flag indicating whether or not the element is struckthrough (defaults to false)
  * `isSubscript` - a flag indicating whether or not the element is subscript (defaults to false)
  * `isSuperscript` - a flag indicating whether or not the element is superscript (defaults to false)
  * `isUnderline` - a flag indicating whether or not the element is underline (defaults to false)
  * `isVisible` - a flag indicating whether or not the element is visible (defaults to true)
* Paragraph-state
  * `index` - the paragraph's index (defaults to 0)

Admittedly, it's a little clunky, but you can access an element's style like so:

```php
use Jstewmc\Rtf\Document;

$document = new Document('{\b foo\b0}');

$document
	->getRoot()         // get the document's root group
	->getFirstChild()   // get the "\b" control word element
	->getNextSibling()  // get the "foo" text element
	->getStyle()        // get the text element's style
	->getCharacter()    // get the style's character state
	->getIsBold();      // returns true
```

A document will be rendered and its elements styled on instantiation. However, any changes to the document, like inserting or removing elements, will cause a re-render of the element's parent group.

## Rich Text Format (RTF)

This library adheres to the [Rich Text Format Version 1.5 Specification (1997)](http://www.biblioscape.com/rtf15_spec.htm), and it adds supports for the ignored control word `\*`.

If you aren't familiar with the Rich Text Format (RTF) language, it's relatively simple. There are four main language components: groups, control words, control symbols, and text.

### Groups

Groups are the fundamental building blocks of an RTF document. A group consists of text, control words, control symbols, or other groups enclosed in braces (`"{"` and `"}"`).

Like an XML document, an RTF document must have a root group. Within the root group there is a *header*, a group of document-formatting control words that, if they occur, must do so before any text, and the *body*, the content of the document.

A document header must precede the first plain-text character in the document, and may include groups for fonts, styles, screen-color, pictures, footnotes, comments (aka, annotations), headers, footers, summary information, fields, and bookmarks as well as document-, section-, paragraph-, and character-formatting properties.

Groups can be nested. Generally, formatting within a group affects only the text in that group, and text within a group inherits the formatting of the parent group. However, the footnote, comment (aka, annotation), header, and footer groups do not inherit the formatting of their parent group. (To ensure that these groups are always formatted correctly, you should set the formatting of these groups to the default with the `\sectd`, `\pard`, and `\plain` control words, and then add any desired formatting.)

### Control words

A control word is a specially-formatted command used to perform actions in an RTF document such as: insert special characters, set paragraph-formatting, set character-formatting, etc.

A control word takes the following form: `\<word>[<delimiter>]`, where `word` is a string of fewer than 32 lowercase, alphabetic characters, and `delimiter` is one of the following:

* A space (" ") - A space is considered part of the control word and does not appear in the document. However, any characters following the space, including spaces, will appear in the document.
* A digit (0-9) or hyphen ("-") - A digit or hyphen indicates a numeric parameter follows. The subsequent digital sequence is then delimited by a space or any other character besides a letter or digit. The parameter can be a positive or negative number, generally between -32,767 and 32,767. However, readers should accept any arbitrary string of digits as a legal parameter.
* Any character besides a letter or digit - In this case, the delimiting character terminates the control word, but is not part of the control word.

The parameters of certain control words (for example, bold, `\b`) have only two states. When such a control word has no parameter (or has a non-zero parameter), it is assumed that the control word turns on the property. When such a control word has a parameter of `0`, it is assumed to turn off the property.

### Control symbols

A control symbol consists of a backslash followed by a single, non-alphabetic character (aka, a symbol). A control symbol usually inserts a special character. For example, the control symbol `\~` represents a non-breaking space.

Generally, control symbols take no parameters. However, the apostrophe control symbol takes a two-digit hexadecimal parameter (e.g., `\'hh`).

### Text

Text is any character that isn't a group-open, group-close, control word, or control symbol.

Special characters like the backlash (`"\"`), open-bracket (`"{"`), and close-bracket (`"}"`) must be escaped with the backslash character (`"\"`).

### Line endings

The RTF specification instructs writers to insert line-feeds and/or carriage-returns every 255 characters or so, and it instructs readers to ignore them. Instead, line breaks should be controlled with the `\line` control word (among others), and paragraphs should be controlled with the `\par` control word.

This library will ignore an *un-escaped* line-feed or carriage return. However, it will treat an *escaped* line-feed or carriage-return as an implicit `\par` control word.

### Destinations

A destination is a group of related text that could appear in a different position (aka, "destination") within the document. Destinations may also be text that is used but should not appear in a document.

For the purposes of this library, destinations must be preceded by the ignored control symbol, `\*`.

Because this library doesn't support any destination control words, all destinations are ignored when formatting the document as text or html.

### Supported control words and symbols

This library only supports a small subset of the several hundred possible RTF control words and control symbols (see [RTF Specification 1.5](http://www.biblioscape.com/rtf15_spec.htm) or [Latex2Rtf Documentation](http://latex2rtf.sourceforge.net/rtfspec_7.html#rtfspec_specialchar) for details):

* Character formatting control words
  * `\b`, bold
  * `\i`, italic
  * `\plain`, reset character format
  * `\strike`, strikethrough
  * `\sub`, subscript
  * `\super`, superscript
  * `\ul` and `\ulnone`, underline (and underline off)
  * `\v`, visibilty
* Special character control words
  * `\bullet`, bullet character
  * `\chdate`, current date string
  * `\chdpa`, current date string, abbreviated
  * `\chdpl`, current date string, long form
  * `\chtime`, current time string
  * `\emdash`, emdash
  * `\emspace`, emspace
  * `\endash`, endash
  * `\enspace`, enspace
  * `\ldblquote`, left-double-quote
  * `\line`, line-break
  * `\left`, left-quote
  * `\qmspace`, qmspace
  * `\rdblquote`, right-double-quote
  * `\rquote`, right-quote
  * `\tab`, tab
  * `\u`, unicode-escape
* Paragraph control words
  * `\par`, new paragraph
  * `\pard`, reset paragraph format

This library doesn't support the following control words:

* Pictures
* Objects
* Tables
* Borders and shading
* Bullets and numbering
* And much more!

If this library encounters a control word or control symbol it doesn't support, it'll create a generic control word or control symbol element, `Element\Control\Word` or `Element\Control\Symbol`, respectively. When formatting the document as html or plain text, unsupported control words are ignored, and their text appears in the document, unless the group is a destination.

## License

This library is released under the [MIT license](https://github.com/jstewmc/rtf/blob/master/LICENSE).

## Acknowledgements

In February 2015, I started a project that required reading and writing RTF files. Actually, it required reading and writing files in the Court Reporter extension of the RTF language, [RTF-CRE](http://www.legalxml.org/workgroups/substantive/transcripts/cre-spec.htm).

I couldn't find a library that was easily extensible with new control words and control symbols. So, I wrote my own (for better or worse haha).

Many thanks to the authors of the following articles for helping me get started:

* [PHP: Reading the clean text from RTF](http://webcheatsheet.com/php/reading_the_clean_text_from_rtf.php)
* [A working RTF to HTML converter in PHP](http://www.websofia.com/2014/05/a-working-rtf-to-html-converter-in-php/)
