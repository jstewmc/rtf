<?php

namespace Jstewmc\Rtf;

class SnippetTest extends \PHPUnit\Framework\TestCase
{
    /* !__construct() */

    /**
     * __construct() should return snippet if source does not exist
     */
    public function testReadReturnsSnippetWhenSourceDoesNotExist()
    {
        $snippet = new Snippet();

        $this->assertTrue($snippet instanceof Snippet);
        $this->assertEquals([], $snippet->getChildren());

        return;
    }

    /**
     * __construct() should return snippet if source does exist
     */
    public function testConstructReturnsSnippetWhenSourceDoesExist()
    {
        $snippet = new Snippet('mis\cxds ');

        $this->assertTrue($snippet instanceof Snippet);
        $this->assertEquals(2, $snippet->getLength());

        return;
    }


    /* !read() */

    /**
     * read() should throw an InvalidArgumentException if $string is not a string
     */
    public function testReadThrowsInvalidArgumentExceptionWhenStringIsNotAString()
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Snippet())->read(999);
    }

    /**
     * read() should return true if $string is empty
     */
    public function testReadReturnsTrueWhenStringIsEmpty()
    {
        return $this->assertTrue((new Snippet())->read(''));
    }

    /**
     * read() should return true if $string is not empty
     */
    public function testReadReturnsTrueWhenStringIsNotEmpty()
    {
        $string = '\cxds ing';

        $snippet = new Snippet();

        $expected = (new Renderer())->render(
            (new Element\Group())
                ->appendChild(new Element\Control\Word\Cxds())
                ->appendChild(new Element\Text('ing'))
        );

        $this->assertTrue($snippet->read($string));
        $this->assertEquals($expected->getChildren(), $snippet->getChildren());

        return;
    }


    /* !write() */

    /**
     * write() should throw InvalidArgumentException if $format is not a string
     */
    public function testWriteThrowsInvalidArgumentExceptionWhenFormatIsNotAString()
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Snippet())->write(999);

        return;
    }

    /**
     * write() should throw InvalidArgumentException if $format is not valid
     */
    public function testWriteThrowsInvalidArgumentExceptionWhenFormatIsNotValid()
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Snippet())->write('foo');

        return;
    }

    /**
     * write() should return string if $format is valid
     */
    public function testWriteReturnsStringWhenFormatIsValid()
    {
        $string = '\cxds ing';

        $snippet = new Snippet();
        $snippet->read($string);

        return $this->assertEquals($string, $snippet->write());
    }
}
