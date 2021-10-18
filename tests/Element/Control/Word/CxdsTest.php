<?php

namespace Jstewmc\Rtf\Element\Control\Word;

use Jstewmc\Rtf\Element\Group;
use Jstewmc\Rtf\Element\Text;
use Jstewmc\Rtf\Style;

/**
 * Tests for the Cxp control word
 */
class CxdsTest extends \PHPUnit\Framework\TestCase
{
    /* !run() */
    
    /**
     * run() should do nothing if previous text element does not exist
     */
    public function testRun_doesNothing_ifPreviousTextElementDoesNotExist()
    {
        $word = new Cxds();
        
        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($word)->render();
        
        // hmm, I don't know what to assert here
        // I guess we just want to be sure nothing bad happens?
        
        return;
    }
    
    /**
     * run() should do nothing if next text element does not exist
     */
    public function test_run_doesNothing_ifNextTextElementDoesNotExist()
    {
        $word = new Cxds();
        
        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($word)
            ->render();
        
        // hmm, I don't know what to assert here
        // I guess we just want to be sure nothing bad happens?
        
        return;
    }
    
    /**
     * run() should do nothing if previous text element does not end with space
     */
    public function testRun_doesNothing_ifPreviousTextElementDoesNotEndWithSpace()
    {
        $word = new Cxds();
        $text = (new Text())->setText('foo');
        
        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($text)
            ->appendChild($word)
            ->render();
        
        $this->assertEquals('foo', $text->getText());
        
        return;
    }
    
    /**
     * run() should do nothing if next text element does not start with space
     */
    public function test_run_doesNothing_ifNextTextElementDoesNotStartWithSpace()
    {
        $word = new Cxds();
        
        $text = (new Text())->setText('foo');
        
        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($word)
            ->appendChild($text)
            ->render();
        
        $this->assertEquals('foo', $text->getText());
        
        return;
    }
    
    /**
     * run() should delete space if previous text element ends with space
     */
    public function testRun_deletesSpace_ifPreviousTextElementDoesEndWithSpace()
    {
        $word = new Cxds();
        $text = (new Text())->setText('foo ');  // note the space
        
        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($text)
            ->appendChild($word)
            ->render();
        
        $this->assertEquals('foo', $text->getText());
        
        return;
    }
    
    /**
     * run() should delete space if next text element starts with space
     */
    public function test_run_deletesSpace_ifNextTextElementDoesStartWithSpace()
    {
        $word = new Cxds();
        
        $text = (new Text())->setText(' foo');  // note the space
        
        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($word)
            ->appendChild($text)
            ->render();
        
        $this->assertEquals('foo', $text->getText());
        
        return;
    }
    
    /**
     * run() should delete space if both text elements have spaces
     */
    public function test_run_deletesSpace_ifBothTextElementsHaveSpaces()
    {
        $word = new Cxds();
        
        $text1 = (new Text())->setText('foo ');  // note the space
        $text2 = (new Text())->setText(' bar');  // note the space
        
        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($text1)
            ->appendChild($word)
            ->appendChild($text2);
            
        $parent->render();
        
        $this->assertEquals('foobar', $parent->format('text'));
        
        return;
    }
    
    /**
     * run() should do nothing if neither text element has spaces
     */
    public function test_run_deletesSpace_ifNeitherTextElementHasSpaces()
    {
        $word = new Cxds();
        
        $text1 = (new Text())->setText('foo');
        $text2 = (new Text())->setText('bar');
        
        $parent = (new Group())
            ->setStyle(new Style())
            ->appendChild($text1)
            ->appendChild($word)
            ->appendChild($text2);
        
        $parent->render();
        
        $this->assertEquals('foobar', $parent->format('text'));
        
        return;
    }
}
