<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the V control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class VTest extends \PHPUnit\Framework\TestCase
{
    /* !run() */
    
    /**
     * run() should make characters visible if parameter is omitted
     */
    public function testRunDoesShowWhenParameterIsOmitted()
    {
        $style = new \Jstewmc\Rtf\Style();
        
        $element = new V();
        $element->setStyle($style);
        
        $element->run();
        
        $this->assertTrue($element->getStyle()->getCharacter()->getIsVisible());
        
        return;
    }
    
    /**
     * run() should make characters visible if parameter is not zero
     */
    public function testRunDoesShowWhenParameterIsNotZero()
    {
        $style = new \Jstewmc\Rtf\Style();
        
        $element = new V();
        $element->setParameter('1');
        $element->setStyle($style);
        
        $element->run();
        
        $this->assertTrue($element->getStyle()->getCharacter()->getIsVisible());
        
        return;
    }
    
    /**
     * run() should make characters visible if parameter is not zero
     */
    public function testRunDoesNotShowWhenParameterIsZero()
    {
        $style = new \Jstewmc\Rtf\Style();
        
        $element = new V();
        $element->setParameter('0');
        $element->setStyle($style);
        
        $element->run();
        
        $this->assertFalse($element->getStyle()->getCharacter()->getIsVisible());
        
        return;
    }
}
