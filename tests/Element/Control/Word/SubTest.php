<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the Sub control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class SubTest extends \PHPUnit\Framework\TestCase
{
    /* !run() */
    
    /**
     * run() should subscript the characters if parameter is not zero
     */
    public function testRunDoesSubscriptWhenParameterIsNotZero()
    {
        $style = new \Jstewmc\Rtf\Style();
        
        $element = new Sub();
        $element->setParameter('1');
        $element->setStyle($style);
        
        $this->assertFalse($element->getStyle()->getCharacter()->getIsSubscript());
        
        $element->run();
        
        $this->assertTrue($element->getStyle()->getCharacter()->getIsSubscript());
        
        return;
    }
    
    /**
     * run() should update the element's style
     */
    public function testRunDoesNotSubscriptWhenParameterIsZero()
    {
        $style = new \Jstewmc\Rtf\Style();
        
        $element = new Sub();
        $element->setParameter('0');
        $element->setStyle($style);
        
        $this->assertFalse($element->getStyle()->getCharacter()->getIsSubscript());
        
        $element->run();
        
        $this->assertFalse($element->getStyle()->getCharacter()->getIsSubscript());
        
        return;
    }
}
