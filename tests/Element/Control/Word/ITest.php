<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A test suite for the I control word
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class ITest extends \PHPUnit\Framework\TestCase
{
    /* !run() */
    
    /**
     * run() should italisize the characters if the parameter is not zero
     */
    public function testRun_doesItalicize_ifParameterIsNotZero()
    {
        $style = new \Jstewmc\Rtf\Style();
        
        $element = new I();
        $element->setParameter('1');
        $element->setStyle($style);
        
        $this->assertFalse($element->getStyle()->getCharacter()->getIsItalic());
        
        $element->run();
        
        $this->assertTrue($element->getStyle()->getCharacter()->getIsItalic());
        
        return;
    }
    
    /**
     * run() should italicize the characters if the parameter is zero
     */
    public function testRun_doesNotItalicize_ifParameterIsZero()
    {
        $style = new \Jstewmc\Rtf\Style();
        
        $element = new I();
        $element->setParameter('0');
        $element->setStyle($style);
        
        $this->assertFalse($element->getStyle()->getCharacter()->getIsItalic());
        
        $element->run();
        
        $this->assertFalse($element->getStyle()->getCharacter()->getIsItalic());
        
        return;
    }
}
