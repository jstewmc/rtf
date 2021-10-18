<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Tab control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class TabTest extends \PHPUnit\Framework\TestCase
{
    /* !format() */
    
    /**
     * format() should return string if format is html
     */
    public function testFormatReturnsStringWhenFormatIsHtml()
    {
        $word = new Tab();
        
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
        $word = new Tab();
        
        $expected = "\t";
        $actual   = $word->format('text');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
}
