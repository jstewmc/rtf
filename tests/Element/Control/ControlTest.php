<?php

namespace Jstewmc\Rtf\Element\Control;

/**
 * A test suite for the control class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class ControlTest extends \PHPUnit\Framework\TestCase
{
    /* setIsSpaceDelimited() / getIsSpaceDelimited() */

    /**
     * setIsSpaceDelimited() and getIsSpaceDelimited() should set and get the
     *     flag, respectively
     */
    public function testSetGetIsSpaceDelimited()
    {
        $control = new TestControl();
        $control->setIsSpaceDelimited(true);

        $this->assertTrue($control->getIsSpaceDelimited());

        return;
    }
}
