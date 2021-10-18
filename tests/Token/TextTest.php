<?php

namespace Jstewmc\Rtf\Token;

use Jstewmc\Stream;
use Jstewmc\Chunker;

/**
 * A test suite for the Token\Text class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class TextTest extends \PHPUnit\Framework\TestCase
{

    /* !Get/set methods */

    /**
     * setText() and getText() should set and get the character
     */
    public function testSetCharacterAndGetText()
    {
        $text = 'foo bar baz';

        $token = new Text();
        $token->setText($text);

        $expected = $text;
        $actual   = $token->getText();

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !__construct() */

    /**
     * __construct() should return object is $text is null
     */
    public function testConstructReturnsTokenWhenTextIsNull()
    {
        $token = new Text();

        $this->assertTrue($token instanceof Text);

        return;
    }

    /**
     * __construct() should return object if $character is string
     */
    public function testConstructReturnsTokenWhenTextIsString()
    {
        $text = 'foo bar baz';

        $token = new Text($text);

        $expected = $text;
        $actual   = $token->getText();

        $this->assertTrue($token instanceof Text);
        $this->assertEquals($expected, $actual);

        return;
    }


    /* !__toString() */

    /**
     * __toString() should return empty string if the text token is empty
     */
    public function testToStringReturnsStringWhenTextIsEmpty()
    {
        $token = new Text();

        $this->assertEquals('', (string)$token);

        return;
    }

    /**
     * __toString() should return empty string if the text token is empty
     */
    public function testToStringReturnsStringWhenTextIsNotEmpty()
    {
        $text = 'foo';

        $token = new Text($text);

        $expected = $text;
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !createFromStream() */

    /**
     * createFromStream() should return false if $stream is empty
     */
    public function testCreateFromStreamReturnsFalseWhenCharactersIsEmpty()
    {
        $chunker = new Chunker\Text();

        $stream = new Stream\Stream($chunker);

        return $this->assertFalse(Text::createFromStream($stream));
    }

    /**
     * createFromStream() should return text token up to control word
     */
    public function testCreateFromStreamReturnsTextWhenCharactersHasControlWord()
    {
        $chunker = new Chunker\Text('foo \\bar');

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('foo ', $token->getText());
        // $this->assertEquals(3, key($characters));

        return;
    }

    /**
     * createFromStream() should return text token up to control symbol
     */
    public function testCreateFromStreamReturnsTextWhenCharactersHasControlSymbol()
    {
        $chunker = new Chunker\Text('foo \\+');

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('foo ', $token->getText());
        // $this->assertEquals(3, key($characters));

        return;
    }

    /**
     * createFromStream() should return text token up to group-open
     */
    public function testCreateFromStreamReturnsTextWhenCharactersHasGroupOpen()
    {
        $chunker = new Chunker\Text('foo {');

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('foo ', $token->getText());
        // $this->assertEquals(3, key($characters));

        return;
    }

    /**
     * createFromStream() should return text token up to group-close
     */
    public function testCreateFromStreamReturnsTextWhenCharactersHasGroupClose()
    {
        $chunker = new Chunker\Text('foo }');

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('foo ', $token->getText());
        // $this->assertEquals(3, key($characters));

        return;
    }

    /**
     * createFromStream() should return text token if $characters contains *unescaped*
     *     line-feed
     */
    public function testCreateFromStreamReturnsTextWhenCharactersHasLineFeedUnescaped()
    {
        $chunker = new Chunker\Text("foo\nbar");

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('foobar', $token->getText());
        // $this->assertNull(key($characters));

        return;
    }

    /**
     * createFromStream() should return text token if $characters contains *escaped*
     *     line-feed
     */
    public function testCreateFromStreamReturnsTextWhenCharactersHasLineFeedEscaped()
    {
        $chunker = new Chunker\Text("foo\\\nbar");

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('foo', $token->getText());
        // $this->assertEquals(2, key($characters));

        return;
    }

    /**
     * createFromStream() should return text token if $characters contains *unescaped*
     *     carriage-return
     */
    public function testCreateFromStreamReturnsTextWhenCharactersHasCarriageReturnUnescaped()
    {
        $chunker = new Chunker\Text("foo\rbar");

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('foobar', $token->getText());
        // $this->assertNull(key($characters));

        return;
    }

    /**
     * createFromStream() should return text token if $characters contains *escaped*
     *     carriage-return
     */
    public function testCreateFromStreamReturnsTextWhenCharactersHasCarriageReturnEscaped()
    {
        $chunker = new Chunker\Text("foo\\\rbar");

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('foo', $token->getText());
        // $this->assertEquals(2, key($characters));

        return;
    }

    public function testCreateFromStreamReturnsTextWhenCharacterEvaluatesToEmpty()
    {
        $chunker = new Chunker\Text("0");

        $stream = new Stream\Stream($chunker);

        $token = Text::createFromStream($stream);

        $this->assertTrue($token instanceof Text);
        $this->assertEquals('0', $token->getText());

        return;
    }
}
