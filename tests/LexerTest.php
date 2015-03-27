<?php
	
use Jstewmc\Rtf\Lexer;
use Jstewmc\Rtf\Token;
use Jstewmc\Stream;

/**
 * A test suite for the Lexer class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class LexerTest extends PHPUnit_Framework_TestCase
{
	/* !Providers */
	
	public function notAStringProvider()
	{
		return [
			[true],
			[1],
			[1.0],
			// ['foo'],
			[[]],
			[new StdClass()]
		];		
	}
	
	
	/* !lex() */
	
	/**
	 * lex() should return an empty array if $stream is empty
	 */
	public function testLex_returnsString_ifStreamIsEmpty()
	{
		$stream = new Stream\Text();
		
		$lexer = new Lexer();
		
		$expected = [];
		$actual = $lexer->lex($stream);
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a group-open character
	 */
	public function testLex_lexesGroupOpen()
	{
		$stream = new Stream\Text('{');
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Group\Open()];
		$actual   = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a group-close character
	 */
	public function testLex_lexesGroupClose()
	{
		$stream = new Stream\Text('}');
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Group\Close()];
		$actual   = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a control word
	 */
	public function testLex_lexesControlWord()
	{
		$stream = new Stream\Text('\foo');
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Control\Word('foo')];
		$actual   = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a control symbol
	 */
	public function testLex_lexesControlSymbol()
	{
		$stream = new Stream\Text('\+');
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Control\Symbol('+')];
		$actual   = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex text
	 */
	public function testLex_lexesText()
	{
		$stream = new Stream\Text('foo');
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Text('foo')];
		$actual = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex text that evaluates to false
	 *
	 * @group  foo
	 */
	public function testLex_lexesTextThatEvaluatesToFalse()
	{
		$stream = new Stream\Text('0');
		
		$lexer = new Lexer();
		
		$expected = [new Token\Text('0')];
		$actual   = $lexer->lex($stream);
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a literal character
	 */
	public function testLex_lexesLiteralCharacter()
	{
		// remember PHP uses the "\" as its own escape character
		$stream = new Stream\Text('\\\\');
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Text('\\')];
		$actual   = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex an *escaped* line-feed
	 */
	public function testLex_lexesLineFeedEscaped()
	{
		$stream = new Stream\Text("\\\n");
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Control\Word('par')];
		$actual   = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex an *escaped* line-feed
	 */
	public function testLex_lexesLineFeedUnescaped()
	{
		$stream = new Stream\Text("f\noo");
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Text('foo')];
		$actual = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex an *escaped* carriage return
	 */
	public function testLex_lexesCarriageReturnEscaped()
	{
		$stream = new Stream\Text("\\\r");
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Control\Word('par')];
		$actual   = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex an *unescaped* carriage return
	 */
	public function testLex_lexesCarriageReturnUnescaped()
	{
		$stream = new Stream\Text("f\roo");
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Text('foo')];
		$actual = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a tab character
	 */
	public function testLex_lexesTabCharacter()
	{
		$stream = new Stream\Text("\t");
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [new Token\Control\Word('tab')];
		$actual   = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a group
	 */
	public function testLex_lexesGroup()
	{
		$stream = new Stream\Text("{\b foo \b0 bar}");
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [
			new Token\Group\Open(),
			(new Token\Control\Word('b'))->setIsSpaceDelimited(true),
			new Token\Text('foo '),
			(new Token\Control\Word('b', 0))->setIsSpaceDelimited(true),
			new Token\Text('bar'),
			new Token\Group\Close()
		];
		$actual = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a nested group
	 */
	public function testLex_lexesGroupNested()
	{
		$stream = new Stream\Text("{\b {\i foo}} bar");
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [
			new Token\Group\Open(),
			(new Token\Control\Word('b'))->setIsSpaceDelimited(true),
			new Token\Group\Open(),
			(new Token\Control\Word('i'))->setIsSpaceDelimited(true),
			new Token\Text('foo'),
			new Token\Group\Close(),
			new Token\Group\Close(),
			new Token\Text(' bar')
		];
		$actual = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * lex() should lex a small document
	 */
	public function testLex_lexesDocumentSmall()
	{
		$stream = new Stream\Text(
			'{'
				. '\rtf1\ansi\deff0'
				. '{'
					. '\fonttbl'
					. '{'
						. '\f0\fnil\fcharset0 Courier New;'
					. '}'
				. '}'
				. '{'
					. '\*\generator Msftedit 5.41.15.1516;'
				. '}'
				. '\viewkind4\uc1\pard\lang1033\f0\fs20'
				. 'My dog is not like other dogs.\par'."\n"
				. 'He doesn\'t care to walk, \par'."\n"
				. 'He doesn\'t bark, he doesn\'t howl.\par'."\n"
				. 'He goes "Tick, tock. Tick, tock."\par'
			. '}');
		
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		$expected = [
			new Token\Group\Open(),
			new Token\Control\Word('rtf', 1),
			new Token\Control\Word('ansi'),
			new Token\Control\Word('deff', 0),
			new Token\Group\Open(),
			new Token\Control\Word('fonttbl'),
			new Token\Group\Open(),
			new Token\Control\Word('f', 0),
			new Token\Control\Word('fnil'),
			(new Token\Control\Word('fcharset', 0))->setIsSpaceDelimited(true),
			new Token\Text('Courier New;'),
			new Token\Group\Close(),
			new Token\Group\Close(),
			new Token\Group\Open(),
			new Token\Control\Symbol('*'),
			(new Token\Control\Word('generator'))->setIsSpaceDelimited(true),
			new Token\Text('Msftedit 5.41.15.1516;'),
			new Token\Group\Close(),
			new Token\Control\Word('viewkind', 4),
			new Token\Control\Word('uc', 1),
			new Token\Control\Word('pard'),
			new Token\Control\Word('lang', 1033),
			new Token\Control\Word('f', 0),
			new Token\Control\Word('fs', 20),
			new Token\Text('My dog is not like other dogs.'),
			new Token\Control\Word('par'),
			new Token\Text('He doesn\'t care to walk, '),
			new Token\Control\Word('par'),
			new Token\Text('He doesn\'t bark, he doesn\'t howl.'),
			new Token\Control\Word('par'),
			new Token\Text('He goes "Tick, tock. Tick, tock."'),
			new Token\Control\Word('par'),
			new Token\Group\Close()
		];
		$actual = $tokens;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
