<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Emspace control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class EmspaceTest extends \PHPUnit\Framework\TestCase
{
    /* !format() */
    
    /**
     * format() should return string if format is html
     */
    public function testFormatReturnsStringWhenFormatIsHtml()
    {
        $word = new Emspace();
        
        $expected = '&emsp;';
        $actual   = $word->format('html');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
    
    /**
     * format() should return string if format is html
     */
    public function testFormatReturnsStringWhenFormatIsText()
    {
        $word = new Emspace();
        
        $expected = html_entity_decode('&emsp;');
        $actual   = $word->format('text');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
}
