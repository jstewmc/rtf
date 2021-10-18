<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Bullet control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class BulletTest extends \PHPUnit\Framework\TestCase
{
    /* !format() */
    
    /**
     * format() should return string if format is html
     */
    public function testFormatReturnsStringWhenFormatIsHtml()
    {
        $bullet = new Bullet();
        
        $expected = '&bull;';
        $actual   = $bullet->format('html');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
    
    /**
     * format() should return string if format is html
     */
    public function testFormatReturnsStringWhenFormatIsText()
    {
        $bullet = new Bullet();
        
        $expected = html_entity_decode('&bull;');
        $actual   = $bullet->format('text');
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
}
