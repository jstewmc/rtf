<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * A test suite for the apostrophe symbol
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
 
class ApostropheTest extends \PHPUnit\Framework\TestCase
{
    /* !format() */
    
    /**
     * format() should return a string if the format is html
     */
    public function testFormatReturnsStringWhenFormatIsHtml()
    {
        $word = new Apostrophe('22');
        
        $expected = '&#x22;';
        $actual   = $word->format('html');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
    
    /**
     * format() should return a string if the format is html
     */
    public function testFormatReturnsStringWhenFormatIsText()
    {
        $word = new Apostrophe('22');
        
        $expected = html_entity_decode('&#x22;');
        $actual   = $word->format('text');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
}
