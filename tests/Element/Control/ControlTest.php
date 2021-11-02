<?php

namespace Jstewmc\Rtf\Element\Control;

class ControlTest extends \PHPUnit\Framework\TestCase
{
    public function testGetIsSpaceDelimitedReturnsBool(): void
    {
        $this->assertTrue((new TestControl())->getIsSpaceDelimited());
    }

    public function testSetIsSpaceDelimitedReturnsSelf(): void
    {
        $control = new TestControl();

        $this->assertSame($control, $control->setIsSpaceDelimited(false));
    }
}
