<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * A test suite for the symbol class
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
     * setParameter() and getParameter() should set and get parameter, respectively
     */
    public function testSetGetParameter()
    {
        $parameter = 'foo';

        $symbol = new Symbol();
        $symbol->setParameter($parameter);

        $expected = $parameter;
        $actual   = $symbol->getParameter();

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * setSymbol() and getSymbol() should set and get the symbol, respectively
     */
    public function testSetGetSymbol()
    {
        $character = '+';

        $symbol = new Symbol();
        $symbol->setSymbol($character);

        $expected = $character;
        $actual   = $symbol->getSymbol();

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !__construct() */

    /**
     * __construct() should return symbol element if $parameter is null
     */
    public function testConstructReturnsSymbolWhenParameterIsNull()
    {
        $symbol = new Symbol();

        $this->assertTrue($symbol instanceof Symbol);
        $this->assertEquals('', $symbol->getParameter());

        return;
    }

    /**
     * __construct() should return symbol element if $parameter is not null
     */
    public function testConstructReturnsSymbolWhenParameterIsNotNull()
    {
        $parameter = 'foo';

        $symbol = new Symbol($parameter);

        $this->assertTrue($symbol instanceof Symbol);
        $this->assertEquals($parameter, $symbol->getParameter());

        return;
    }


    /* !__toString() */

    /**
     * __toString() should return string if parameter does not exist
     */
    public function testToStringReturnsStringWhenParameterDoesNotExist()
    {
        $symbol = new Symbol();
        $symbol->setSymbol('*');

        $this->assertEquals('\\* ', (string)$symbol);

        return;
    }

    /**
     * __toString() should return string if parameter does exist
     */
    public function testToStringReturnsStringWhenParameterDoesExist()
    {
        $symbol = new Symbol();
        $symbol->setSymbol('\'');
        $symbol->setParameter('foo');

        $this->assertEquals('\\\'foo ', (string)$symbol);

        return;
    }

    /**
     * __toString() should return string if the control symbol is not space delimited
     */
    public function testToStringReturnsStringWhenNotSpaceDelimited()
    {
        $symbol = new Symbol();
        $symbol->setSymbol('+');
        $symbol->setIsSpaceDelimited(false);

        $expected = '\\+';
        $actual   = (string)$symbol;

        $this->assertEquals($expected, $actual);

        return;
    }
}
