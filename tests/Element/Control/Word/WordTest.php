<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the word class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class WordTest extends \PHPUnit\Framework\TestCase
{
    /* !setIsIgnored() / getIsIgnored() */

    /**
     * setIsIgnored() and getIsIgnored() should set and get the control word's is-
     *     ignored property, respectively
     */
    public function testSetGetIsIgnored()
    {
        $isIgnored = true;

        $word = new Word('foo');
        $word->setIsIgnored($isIgnored);

        $expected = $isIgnored;
        $actual   = $word->getIsIgnored();

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !setWord()/getWord() */

    /**
     * setWord() and getWord() should set and get the control word's word, respectively
     */
    public function testSetGetWord()
    {
        $word = new Word('foo');

        $actual   = $word->getWord();

        $this->assertEquals('foo', $actual);

        return;
    }


    /* !setParameter()/getParameter() */

    /**
     * setWord() and getWord() should set and get the control word's parameter, respectively
     */
    public function testSetGetParameter()
    {
        $parameter = 1;

        $word = new Word('foo');
        $word->setParameter($parameter);

        $expected = $parameter;
        $actual   = $word->getParameter();

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !__construct() */

    /**
     * __construct() should return word element if $parameter is null
     */
    public function testConstructReturnsElementWhenParameterIsNull()
    {
        $word = new Word('foo');

        $this->assertTrue($word instanceof Word);
        $this->assertEquals('foo', $word->getWord());
        $this->assertNull($word->getParameter());

        return;
    }

    /**
     * __construct() should return word element if parameter is not null
     */
    public function testConstructReturnsElementWhenParameterIsNotNull()
    {
        $word = new Word('word', 1);

        $this->assertTrue($word instanceof Word);
        $this->assertEquals('word', $word->getWord());
        $this->assertEquals(1, $word->getParameter());

        return;
    }


    /* !__toString() */

    /**
     * __toString() should return string if not space delimited
     */
    public function testToStringReturnsStringWhenNotSpaceDelimited()
    {
        $word = new Word('b');
        $word->setIsSpaceDelimited(false);

        $this->assertEquals('\\b', (string)$word);

        return;
    }

    /**
     * __toString() should return string if the control word is ignored
     */
    public function testToStringReturnsStringWhenIsIgnored()
    {
        $word = new Word('b');
        $word->setIsIgnored(true);

        $this->assertEquals('\\*\\b ', (string)$word);

        return;
    }

    /**
     * __toString() should return string if parameter does not exist
     */
    public function testToStringReturnsStringWhenParameterDoesNotExist()
    {
        $word = new Word('b');

        $this->assertEquals('\\b ', (string)$word);

        return;
    }

    /**
     * __toString() should return string if parameter does exist
     */
    public function testToStringReturnsStringWhenParameterDoesExist()
    {
        $word = new Word('b');
        $word->setParameter(0);

        $this->assertEquals('\\b0 ', (string)$word);

        return;
    }
}
