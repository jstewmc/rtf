<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\Element;

class RendererTest extends \PHPUnit\Framework\TestCase
{
    public function testRender()
    {
        $root = (new Element\Group())
            ->appendChild(new Element\Text('foo '))
            ->appendChild((new Element\Group())
                ->appendChild(new Element\Control\Word\B())
                ->appendChild(new Element\Text('bar'))
                ->appendChild(new Element\Control\Word\B(0)));

        $this->assertFalse($root->getIsRendered());

        $renderer = new Render();
        $root = ($renderer)($root);

        $this->assertTrue($root instanceof Element\Group);
        $this->assertTrue($root->getIsRendered());
        $this->assertTrue($root
            ->getLastChild()
            ->getChild(1)
            ->getStyle()
            ->getCharacter()
            ->getIsBold());

        return;
    }
}
