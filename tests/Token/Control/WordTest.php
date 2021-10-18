<?php

namespace Jstewmc\Rtf\Token\Control;

use Jstewmc\Stream;
use Jstewmc\Chunker;

/**
 * A test suite for the control word class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class WordTest extends \PHPUnit\Framework\TestCase
{

    /* !Get/set methods */

    public function testGetSetIsSpaceDelimited()
    {
        $token = new Word();
        $token->setIsSpaceDelimited(true);

        $this->assertTrue($token->getIsSpaceDelimited());

        return;
    }

    public function testGetSetParameter()
    {
        $parameter = 1;

        $token = new Word();
        $token->setParameter($parameter);

        $expected = $parameter;
        $actual   = $token->getParameter();

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testGetSetWord()
    {
        $word = 'foo';

        $token = new Word();
        $token->setWord($word);

        $expected = $word;
        $actual   = $token->getWord();

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !__construct() */


    /* !__toString() */

    /**
     * __toString() should return string if word does not exist
     */
    public function testToStringReturnsStringWhenWordDoesNotExist()
    {
        $token = new Word();

        $expected = '';
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * __toString() should return string if word does exist
     */
    public function testToStringReturnsStringWhenWordDoesExist()
    {
        $word = 'foo';

        $token = new Word($word);

        $expected = '\\foo ';
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * __toString() should return string if word and parameter exist
     */
    public function testToStringReturnsStringWhenWordAndParameterDoExist()
    {
        $word = 'foo';
        $parameter = 1;

        $token = new Word($word, $parameter);

        $expected = '\\foo1 ';
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }

    /**
     * __toString() should return string if control symbol is not space delimited
     */
    public function testToStringReturnsStringWhenNotSpaceDelimited()
    {
        $token = new Word('foo');
        $token->setIsSpaceDelimited(false);

        $expected = '\\foo';
        $actual   = (string)$token;

        $this->assertEquals($expected, $actual);

        return;
    }


    /* !createFromStream() */

    /**
     * createFromStream() should throw an InvalidArgumentException if the current
     *     character in $stream is not a backslash
     */
    public function testCreateFromStreamThrowsInvalidArgumentExceptionWhenCurrentCharacterIsNotBackslash()
    {
        $this->expectException(\InvalidArgumentException::class);

        $chunker = new Chunker\Text('foo');

        $stream = new Stream\Stream($chunker);

        Word::createFromStream($stream);

        return;
    }

    /**
     * createFromStream() should throw an InvalidArgumentException if the next
     *     character in $stream is not alphabetic
     */
    public function testCreateFromStreamThrowsInvalidArgumentExceptionWhenNextCharacterIsNotAlphabetic()
    {
        $this->expectException(\InvalidArgumentException::class);

        $chunker = new Chunker\Text('\\1');

        $stream = new Stream\Stream($chunker);

        Word::createFromStream($stream);

        return;
    }

    /**
     * createFromStream() should return false if $stream is empty
     */
    public function testCreateFromStreamReturnsFalseWhenCharactersIsEmpty()
    {
        $chunker = new Chunker\Text();

        $stream = new Stream\Stream($chunker);

        return $this->assertFalse(Word::createFromStream($stream));
    }

    /**
     * createFromStream() should return false if the next character in $stream
     *     is empty
     */
    public function testCreateFromStreamReturnsFalseWhenNextCharacterIsEmpty()
    {
        $chunker = new Chunker\Text('\\');

        $stream = new Stream\Stream($chunker);

        return $this->assertFalse(Word::createFromStream($stream));
    }

    /**
     * createFromStream() should return a word token if a parameter does not exist and
     *     the delimiter is the space character
     */
    public function testCreateFromStreamReturnsTokenWhenParameterDoesNotExistAndDelimiterIsSpace()
    {
        $chunker = new Chunker\Text('\\foo bar');

        $stream = new Stream\Stream($chunker);

        $word = Word::createFromStream($stream);

        $this->assertTrue($word instanceof Word);
        $this->assertEquals('foo', $word->getWord());
        $this->assertTrue($word->getIsSpaceDelimited());
        // $this->assertEquals(4, key($characters));

        return;
    }

    /**
     * createFromStream() should return a word token if a parameter does not exist and
     *     the delimiter is not alphanumeric character
     */
    public function testCreateFromStreamReturnsTokenWhenParameterDoesNotExistAndDelimiterIsCharacter()
    {
        $chunker = new Chunker\Text('\\foo+bar');

        $stream = new Stream\Stream($chunker);

        $word = Word::createFromStream($stream);

        $this->assertTrue($word instanceof Word);
        $this->assertEquals('foo', $word->getWord());
        $this->assertFalse($word->getIsSpaceDelimited());
        // $this->assertEquals(3, key($characters));

        return;
    }

    /**
     * createFromStream() should return a word token if parameter does exist and it's a
     *     positive number
     */
    public function testCreateFromStreamReturnsTokenWhenParameterDoesExistAndPositive()
    {
        $chunker = new Chunker\Text('\\foo123 bar');

        $stream = new Stream\Stream($chunker);

        $word = Word::createFromStream($stream);

        $this->assertTrue($word instanceof Word);
        $this->assertEquals('foo', $word->getWord());
        $this->assertEquals(123, $word->getParameter());
        // $this->assertEquals(7, key($characters));

        return;
    }

    /**
     * createFromStream() should return a word token if parameter does exist and it's a
     *     negative number
     */
    public function testCreateFromStreamReturnsTokenWhenParameterDoesExistAndNegative()
    {
        $chunker = new Chunker\Text('\\foo-123 bar');

        $stream = new Stream\Stream($chunker);

        $word = Word::createFromStream($stream);

        $this->assertTrue($word instanceof Word);
        $this->assertEquals('foo', $word->getWord());
        $this->assertEquals(-123, $word->getParameter());
        // $this->assertEquals(8, key($characters));

        return;
    }

    /**
     * createFromStream() should return a word token if parameter does exist and it's
     *     delimited by a space
     */
    public function testCreateFromStreamReturnsTokenWhenParameterDoesExistAndDelimiterIsSpace()
    {
        $chunker = new Chunker\Text('\\foo1 bar');

        $stream = new Stream\Stream($chunker);

        $word = Word::createFromStream($stream);

        $this->assertTrue($word instanceof Word);
        $this->assertEquals('foo', $word->getWord());
        $this->assertEquals(1, $word->getParameter());
        $this->assertTrue($word->getIsSpaceDelimited());
        // $this->assertEquals(5, key($characters));

        return;
    }

    /**
     * createFromStream() should return a word token if parameter does exist and it's
     *     delimited by any non-alphanumeric character
     */
    public function testCreateFromStreamReturnsTokenWhenParameterDoesExistAndDelimiterIsCharacter()
    {
        $chunker = new Chunker\Text('\\foo1+bar');

        $stream = new Stream\Stream($chunker);

        $word = Word::createFromStream($stream);

        $this->assertTrue($word instanceof Word);
        $this->assertEquals('foo', $word->getWord());
        $this->assertEquals(1, $word->getParameter());
        $this->assertFalse($word->getIsSpaceDelimited());
        // $this->assertEquals(4, key($characters));

        return;
    }
}
