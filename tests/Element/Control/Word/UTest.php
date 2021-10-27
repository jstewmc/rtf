<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the U control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class UTest extends \PHPUnit\Framework\TestCase
{
    /* !format() */
    
    /**
     * format() should return string if format is html
     */
    public function testFormatReturnsStringWhenFormatIsHtml()
    {
        // "&#60" is the less-than character
        $word = new U(60);
        
        $expected = '&#60;';
        $actual   = $word->format('html');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
    
    /**
     * format() should return string if format is text
     */
    public function testFormatReturnsStringWhenFormatIsText()
    {
        $word = new U(60);
        
        $expected = html_entity_decode('&#60;');
        $actual   = $word->format('text');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
}
