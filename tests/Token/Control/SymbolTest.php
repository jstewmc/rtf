<?php

namespace Jstewmc\Rtf\Token\Control;

use Jstewmc\Stream;
use Jstewmc\Chunker;

/**
 * A test suite for the control symbol class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class SymbolTest extends \PHPUnit\Framework\TestCase
{

    /* !Get/set methods */

    /**
     * setIsSpaceDelimited() and getIsSpaceDelimited() should set and get the
     *     isSpaceDelimited flag
     */
    public function testGetSetIsSpaceDelimited()
    {
        $token = new Symbol();
        $token->setIsSpaceDelimited(true);

        $this->assertTrue($token->getIsSpaceDelimited());

        return;
    }

    /**
     * setParameter() and getParameter() should get and set the parameter
     */
    public function testSetAndGetParameter()
    {
        $parameter = 'b';

        $symbol = new Symbol();
        $symbol->setParameter($parameter);

        $expected = $parameter;
        $actual   = $symbol->getParameter();

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * setSymbol() and getSymbol() should, well, get and set the symbol
     */
    public function testSetAndGetSymbol()
    {
        $symbol = '+';

        $symbol = new Symbol();
        $symbol->setSymbol($symbol);

        $expected = $symbol;
        $actual   = $symbol->getSymbol();

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !__construct() */

    /**
     * __construct() should return object if character and parameter are null
     */
    public function testConstructReturnsObjectWhenSymbolAndParameterAreNull()
    {
        $token = new Symbol();

        $this->assertTrue($token instanceof Symbol);

        return;
    }

    /**
     * __construct() should return object if symbol and parameter are not null
     */
    public function testConstructReturnsObjectWhenSymbolAndParameterAreNotNull()
    {
        $symbol = '+';
        $parameter = '123';

        $token = new Symbol($symbol, $parameter);

        $this->assertTrue($token instanceof Symbol);
        $this->assertEquals($symbol, $token->getSymbol());
        $this->assertEquals($parameter, $token->getParameter());

        return;
    }


    /* !__toString() */

    /**
     * __toString() should return string if symbol does not exist
     */
    public function testToStringReturnsStringWhenSymbolDoesNotExist()
    {
        $token = new Symbol();

        $expected = '';
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * __toString() should return string if symbol does exist
     */
    public function testToStringReturnsStringWhenSymbolDoesExist()
    {
        $symbol = '+';

        $token = new Symbol($symbol);

        $expected = "\\$symbol ";
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * __toString() should return string if symbol and parameter do exist
     */
    public function testToStringReturnsStringWhenSymbolAndParameterDoExist()
    {
        $symbol    = '\'';
        $parameter = '99';

        $token = new Symbol($symbol, $parameter);

        $expected = "\\'99 ";
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * __toString() should return string if not space delimited
     */
    public function testToStringReturnsStringWhenNotSpaceDelimited()
    {
        $token = new Symbol('+');
        $token->setIsSpaceDelimited(false);

        $expected = '\\+';
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !createFromStream() */

    /**
     * createFromStream() should throw an InvalidArgumentException if the current character in
     *     $characters is not a backslash ("\")
     */
    public function testCreateFromStreamThrowsInvalidArgumentExceptionWhenCurrentCharacterIsNotBackslash()
    {
        $this->expectException(\InvalidArgumentException::class);

        $chunker = new Chunker\Text('abc');

        $stream = new Stream\Stream($chunker);

        $symbol = Symbol::createFromStream($stream);

        return;
    }

    /**
     * createFromStream() should throw an InvalidArgumentException if the next character in
     *     $characters is alpha-numeric
     */
    public function testCreateFromStreamThrowsInvalidArgumentExceptionWhenNextCharacterIsAlphanumeric()
    {
        $this->expectException(\InvalidArgumentException::class);

        $chunker = new Chunker\Text('\\bc');

        $stream = new Stream\Stream($chunker);

        $symbol = Symbol::createFromStream($stream);

        return;
    }

    /**
     * createFromStream() should return false if $characters is empty
     */
    public function testCreateFromStreamReturnsFalseWhenCharactersIsEmpty()
    {
        $chunker = new Chunker\Text();

        $stream = new Stream\Stream($chunker);

        $this->assertFalse(Symbol::createFromStream($stream));

        return;
    }

    /**
     * createFromStream() should return false if the next character in $characters is empty
     */
    public function testCreateFromStreamReturnsFalseWhenNextCharacterIsEmpty()
    {
        $chunker = new Chunker\Text('\\');

        $stream = new Stream\Stream($chunker);

        $this->assertFalse(Symbol::createFromStream($stream));

        return;
    }

    /**
     * createFromStream() should return a Symbol if the next character is not alphanumeric
     */
    public function testCreateFromStreamReturnsSymbolWhenNextCharacterIsSymbol()
    {
        $chunker = new Chunker\Text('\\_');

        $stream = new Stream\Stream($chunker);

        $symbol = Symbol::createFromStream($stream);

        $this->assertTrue($symbol instanceof Symbol);
        $this->assertEquals('_', $symbol->getSymbol());
        $this->assertNull($symbol->getParameter());
        // $this->assertEquals(1, key($characters));

        return;
    }

    /**
     * createFromStream() should return a Symbol if the next character is not alphanumeric
     *     and the delimiter is a space
     */
    public function testCreateFromStreamReturnsSymbolWhenNextCharacterIsSymbolAndDelimiterIsSpace()
    {
        $chunker = new Chunker\Text('\\_ ');

        $stream = new Stream\Stream($chunker);

        $symbol = Symbol::createFromStream($stream);

        $this->assertTrue($symbol instanceof Symbol);
        $this->assertEquals('_', $symbol->getSymbol());
        $this->assertNull($symbol->getParameter());
        $this->assertTrue($symbol->getIsSpaceDelimited());
        // $this->assertEquals(1, key($characters));

        return;
    }

    /**
     * createFromStream() should return a Symbol if the next character is not alphanumeric
     *     and the delimiter is alphanumeric
     */
    public function testCreateFromStreamReturnsSymbolWhenNextCharacterIsSymbolAndDelimiterIsAlpha()
    {
        $chunker = new Chunker\Text('\\_a');

        $stream = new Stream\Stream($chunker);

        $symbol = Symbol::createFromStream($stream);

        $this->assertTrue($symbol instanceof Symbol);
        $this->assertEquals('_', $symbol->getSymbol());
        $this->assertNull($symbol->getParameter());
        $this->assertFalse($symbol->getIsSpaceDelimited());
        // $this->assertEquals(1, key($characters));

        return;
    }

    /**
     * createFromStream() should return a Symbol with parameters if the next character is
     *     an apostrophe
     */
    public function testCreateFromStreamReturnsSymbolWhenNextCharacterIsApostrophe()
    {
        $chunker = new Chunker\Text("\\'ab");

        $stream = new Stream\Stream($chunker);

        $symbol = Symbol::createFromStream($stream);

        $this->assertTrue($symbol instanceof Symbol);
        $this->assertEquals('\'', $symbol->getSymbol());
        $this->assertEquals('ab', $symbol->getParameter());
        // $this->assertEquals(3, key($characters));

        return;
    }
}
