# rtf
Read and write Rich Text Format (RTF) documents in PHP.

For example:

```php
use Jstewmc\Rtf;

// create a document from source
$document = new Document('{\b foo\b0}');

// let's switch the document's text, "foo", for the text, "bar"...

// create a new text element
$bar = new Element\Text('bar');

// navigate to the "foo" text element and replace it
$document
	->getRoot()           // get the document's root group
	->getFirstChild()     // get the "\b" control word element
	->getNextSibling()    // get the "foo" text element
	->replaceWith($bar);  // replace "foo" with "bar"

// print the changes
echo $document;  // prints "{\b1 bar\b0}"
``` 

## About

In February 2015, I started a project that required reading and writing RTF files. Actually, it required reading and writing files in the Court Reporter extension of the RTF language, RTF-CRE. I couldn't find a library that was easily extensible with new control words and control symbols. So, I wrote my own (for better or worse haha).

## Rich Text Format (RTF)
This library adheres to the [Rich Text Format Version 1.5 Specification (1997)](http://www.biblioscape.com/rtf15_spec.htm).

If you aren't familiar with the Rich Text Format (RTF) language, it's relatively simple. There are four main language components: groups, control words, control symbols, and text.

### Groups
Groups are the fundamental building blocks of an RTF document. A group consists of text, control words, control symbols, or other groups enclosed in braces ("{" and "}").

Like an XML document, an RTF document should have a root group. Within the root group there is a *header*, a group of document-formatting control words that, if they occur, must do so before any text, and the *body*, the content of the document.

Groups can be nested. Generally, formatting within a group affects only the text in that group, and text within a group inherits the formatting of the parent group. 

### Control words
A control word is a specially-formatted command used to perform actions in an RTF document such as: insert special characters, set paragraph-formatting, set character-formatting, etc. 

A control word takes the following form: `\<word>[<delimiter>]`.

`word` is a string of alphabetic characters. RTF is case-sensitive, but all RTF control words are lowercase. A control word must be shorter than 32 characters.

`delimiter` can be one of the following:

* A space (" ") - A space is considered part of the control word and does not appear in the document. However, any characters following the space, including spaces, will appear in the document. 
* A digit (0-9) or hyphen ("-") - A digit or hyphen indicates a numeric parameter follows. The subsequent digital sequence is then delimited by a space or any other character besides a letter or digit. The parameter can be a positive or negative number, generally between -32,767 and 32,767. However, readers should accept any arbitrary string of digits as a legal parameter.
* Any character besides a letter or digit - In this case, the delimiting character terminates the control word, but is not part of the control word.

The parameters of certain control words (for example, bold, `\b`) have only two states. When such a control word has no parameter (or has a non-zero parameter), it is assumed that the control word turns on the property. When such a control word has a parameter of `0`, it is assumed to turn off the property.

### Control symbols
A control symbol consists of a backslash followed by a single, non-alphabetic character (aka, a symbol). A control symbol usually inserts a special character. For example, the control symbol `\~` represents a non-breaking space. 

Generally, control symbols take no delimiters. However, the apostrophe control symbol takes a two-digit hexadecimal parameter (e.g., `\'hh`).

### Text
Text is any character that isn't a group-open, group-close, control word, or control symbol.

Special characters like the backlash (`\\`), open-bracket (`{`), and close-bracket (`}`) are escaped with a backslash (`\\`). For example, the string `\\\\` will produce a literal backslash character.

### Line endings
The RTF specification instructs writers to insert line-feeds and/or carriage-returns every 255 characters, and it instructs readers to ignore them. Instead, line breaks should be controlled with the `\line` control word (among others), and paragraphs should be controlled with the `\par` control word. 

This library will ignore an *un-escaped* line-feed or carriage return. However, it will treat an *escaped* line-feed or carriage-return as an implicit `\par` control word.

## The process

To create a document, this library lexes an RTF string into language tokens, parses the language tokens into the parse tree, and renders the parse tree into the document tree.

### Lexer

The Lexer breaks an RTF string into group-open, group-close, control word, control symbol, and text tokens.

For example:

```php
use Jstewmc\Rtf;

// set the rtf source
$source = '{foo {\b bar\b0}}';

// create the lexer
$lexer = Lexer();

// lex the source into tokens
$tokens = $lexer->lex($source);

// loop through the tokens and echo them to the screen for this example
// in the real world, you would pass them to a parser
//
foreach ($tokens as $token) {
	if ($token instanceof Token\Group\Open) {
		echo "{";
	} elseif ($token instanceof Token\Group\Close) {
		echo "}";	
	} elseif ($token instanceof Token\Control\Word) {
		echo "\\{$token->getWord()}{$token->getParameter()}";
	} elseif ($token instanceof Token\Control\Symbol) {
		echo "\\{$token->getSymbol()}{$token->getParameter()}";
	} elseif ($token instanceof Token\Text) {
		echo \"$token->getText()\";
	}
}
```

The above example would output the following:

```php
{
"foo "
{
\b
"bar"
\b0
}
}
```

### Parser

Given an array of tokens, the Parser creates the document's elements and returns the document's root group.

For example:

```php
use Jstewmc\Rtf;

// ... the array of tokens from the Lexer example above
$tokens = [
	new Token\Group\Open(),
	new Token\Text('foo '),
	new Token\Group\Open(),
	new Token\Control\Word('b'),
	new Token\Text('bar'),
	new Token\Control\Word('b', 0),
	new Token\Group\Close(),
	new Token\Group\Close()
];

// create the parser
$parser = new Parser();

// parse the tokens into the parse tree
$root = $parser->parse($tokens);

// look into the parse tree
echo get_class($root);                   // prints "Jstewmc\Rtf\Element\Group"
echo get_class($root->getFirstChild());  // prints "Jstewmc\Rtf\Element\Text"
echo get_class($root->getLastChild());   // prints "Jstewmc\Rtf\Element\Group"
```

### Render

Given the parse tree's root group, the Renderer reads through the parse tree and computes each element's style. 

```php
use Jstewmc\Rtf;

// ... use the root group from the Parser example above
$group = (new Element\Group())
	->appendChild(new Element\Text('foo '))
	->appendChild((new Element\Group())
		->appendChild(new Element\Control\Word\B())
		->appendChild(new Element\Text('bar'))
		->appendChild(new Element\Control\Word\B(0))
	);

// create the renderer
$renderer = new Renderer();

// render the parse tree into the document tree
$root = $renderer->render($group);

// look into the document tree
$root
	->getLastChild()    // get the last group, the "{\b bar\b0}"
	->getFirstChild()   // get the "\b " control word element
	->getNextSibling()  // get the "bar" text element
	->getStyle()        // get the text element's stye
	->getCharacter()    // get the style's character state
	->getIsBold();      // returns true
```

## Document

Don't worry. You don't have to lex, parse, and render strings on your own. The `Document` class takes care of that for you.

You can create a document *from a string* using the `read()` method or the constructor:

```php
use Jstewmc\Rtf;

$a = new Document();
$a->read('{\b foo\b0}';

$b = new Document('{\b foo\b0}');

$a == $b;  // returns true
```

You can create a document *from a file* using the `load()` method or the constructor:

```php
use Jstewmc\Rtf;

$a = new Document();
$a->load('/path/to/file.rtf');

$b = new Document('/path/to/file.rtf');

$a = $b;  // returns true
```

**Heads up!** The constructor uses the string's first character to determine whether the string is a filename or an RTF string. If the string starts with the open-bracket character (`{`), the string is considered an RTF string. If not, it's considered a filename. If your RTF string is malformed or your filenames are alien, the constructor will not work as expected.

A document can write to a string (and will do so when used as a string) or save to a file:

```php
use Jstewmc\Rtf;

$document = new Document('{\b foo\b0}');

echo $document;           // prints "{\b1 foo\b0 }"
echo $document->write();  // prints "{\b1 foo\b0 }"
echo (string) $document;  // prints "{\b1 foo\b0 }"

$document->save('/path/to/file.rtf');  // puts contents "{\b1 foo\b0 }"
```

## Elements

A document is composed of elements, much like an XML document is composed of nodes. 

There are four types of elements: groups, control words, control symbols, and text.

Group elements and text elements are generically named, `Element\Group` and `Element\Text`, respectively.

Control words and control symbols, on the other hand, are specifically named. For example, the bold control word, `\b`, corresponds to the `Element\Control\Word\B` class, and the asterisk control symbol, `\*`, corresponds to the `Element\Control\Symbol\Asterisk` class.

### Group elements

A group element is the only type of element that can have children. 

You can append, prepend, and insert a group's children:

```php
use Jstewmc\Rtf;

$group = new Element\Group();

$foo = new Element\Text('foo');
$bar = new Element\Text('bar');
$baz = new Element\Text('baz');

$group
	->appendChild($foo)
	->prependChild($bar)
	->insertChild($baz, 1);

$group->getChildren() == [$bar, $baz, $foo];  // returns true
```

You can get a child element or check its existence:

```php
use Jstewmc\Rtf;

$group = new Element\Group();

$foo = new Element\Text('foo');
$bar = new Element\Text('bar');
$baz = new Element\Text('baz');
$qux = new Element\Text('qux');

$group->appendChild($foo)->appendChild($bar)->appendChild($baz);

$foo === $group->getFirstChild();  // returns true
$bar === $group->getChild(1);      // returns true
$baz === $group->getLastChild();   // returns true

$group->hasChild(0);     // returns true
$group->hasChild($foo);  // returns true
$group->hasChild(999);   // returns false
$group->hasChild($qux);  // returns false
```

You can remove and replace a child element:

```php
use Jstewmc\Rtf;

$group = new Element\Group();

$foo = new Element\Text('foo');
$bar = new Element\Text('bar');
$baz = new Element\Text('baz');

$group->appendChild($foo)->appendChild($bar);
$group->getChildren() == [$foo, $bar];  // returns true

$group->replaceChild($foo, $baz);       // returns $foo, the replaced element
$group->getChildren() == [$baz, $bar];  // returns true

$group->removeChild($bar);        // returns $bar, the removed element
$group->getChildren() == [$baz];  // returns true
```

### All elements

You can append and prepend any element (including groups) to a group:

```php
use Jstewmc\Rtf;

$group = new Element\Group();

$foo = new Element\Text('foo');
$foo->appendTo($group);

$bar = new Element\Text('bar');
$bar->prependTo($group);

$group->getChildren() == [$bar, $foo];  // returns true
```

You can insert an element before and after other elements:

```php
use Jstewmc\Rtf;

$group = new Element\Group();

$foo = new Element\Text('foo');
$bar = new Element\Text('bar');
$baz = new Element\Text('baz');

$group->appendChild($foo);

$bar->insertBefore($foo);
$baz->insertAfter($foo);

$group->getChildren() == [$bar, $foo, $baz];  // returns true
```

You can get and put an element's next and previous siblings:

```php
use Jstewmc\Rtf;

$group = new Element\Group();

$foo = new Element\Text('foo');
$bar = new Element\Text('bar');
$baz = new Element\Text('baz');

$group->appendChild($foo);

$foo->putPreviousSibling($bar);
$foo->putNextSibling($baz);

$bar === $foo->getPreviousSibling();  // returns true
$baz === $foo->getNextSibling();      // returns true
```

You can replace an element with another element:

```php
use Jstewmc\Rtf;

$group = new Element\Group();

$foo = new Element\Text('foo');
$bar = new Element\Text('bar');

$foo->appendTo($group);

$foo->replaceWith($bar);

$group->getChildren() == [$bar];  // returns true
```

### Supported controls

There are hundreds of RTF control words and several dozen symbols (see [RTF Specification 1.5](http://www.biblioscape.com/rtf15_spec.htm]) or [Latex2Rtf Documentation](http://latex2rtf.sourceforge.net/rtfspec_7.html#rtfspec_specialchar) for details). 

This library supports a relatively small subset of control words:

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

### Style

The RTF specification lumps an element's style into one huge "group state". I didn't think that was a good idea. So, I created an element's style, like an HTML element's style, and document-, section-, paragraph-, and character-states.

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

It's admittedly a little clunky, but you can access an element's style like the following:

```php
use Jstewmc\Rtf;

$document = new Document('{\b foo\b0}');

$document
	->getRoot()         // get the document's root group
	->getFirstChild()   // get the "\b" control word element
	->getNextSibling()  // get the "foo" text element
	->getStyle()        // get the text element's style
	->getCharacter()    // get the style's character state
	->getIsBold();      // returns true
```

Once a document has been rendered (i.e., the `read()` or `load()` methods have been called) it's style has been computed. Any changes to the document, like inserting or removing elements, will cause a re-render of the new (or old) element's parent group.

## Contributing

Obviously, the biggest area that needs some love is control words and control symbols. This library supports a paltry few. I didn't really need many for my purposes. So, I didn't make them. However, I designed the library so control words and control symbols could be added at will. 

If you're interested, see [CONTRIBUTING.md](https://github.com/jstewmc/rtf/blob/master/CONTRIBUTING.md) for details.

## TODO

There are few things I'd like to work on going forward:

* *Performance* - I haven't had much of an opportunity to test the library on large files yet. I didn't want to get stuck prematurely optimizing. So, I barely optimized anything. It might be nice to do a little performance testing.
* *Search for elements* - For now, there is no way to search for an element like the DOM's `getElementByTagName()` or jQuery's `find()` and `filter()` methods. I'd like to add that.
* *Adding extensions* - I designed the library to make it easy to add control words and control symbols. However, I haven't thought about adding a library of control words and symbols yet.
* *Style magic methods* - I'm not totally happy about users having to know where a state's properties belong. For example, if a user wants to check if a text element is bold, they have to know to call `$element->getStyle()->getCharacter()->getIsBold();`. They have to know that the `isBold` property belongs to the character-state. A magic method that abstracts away the underlying state structure might be better (e.g., `$element->getStyle()->getIsBold();`). 

## Author

Jack Clayton - [clayjs0@gmail.com](mailto:clayjs0@gmail.com)

## License

This library is released under the [MIT license](https://github.com/jstewmc/rtf/blob/master/LICENSE).

## Version

See [CHANGELOG.md](https://github.com/jstewmc/rtf/blob/master/CHANGELOG.md) for details.
