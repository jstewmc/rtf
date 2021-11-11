<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\Element;

class EncodeTest extends \PHPUnit\Framework\TestCase
{
    public function testInvokeReturnsVoidWhenGroupIsEmpty(): void
    {
        $this->assertNull((new Encode())(new Element\Group()));
    }

    public function testInvokeReturnsVoidWhenDocumentDoesNotHaveApostrophes(): void
    {
        $group = (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Mac())
            ->appendChild(new Element\Text('foo'));

        $this->assertNull((new Encode())($group));
    }

    public function testInvokeReturnsVoidWhenGroupHasApostrophes(): void
    {
        $apostrophe = new Element\Control\Symbol\Apostrophe('80');

        $group = (new Element\Group())
            ->appendChild(new Element\Control\Word\Rtf(1))
            ->appendChild(new Element\Control\Word\CharacterSet\Mac())
            ->appendChild($apostrophe);

        (new Encode())($group);

        $this->assertEquals('macintosh', $apostrophe->getEncoding());
    }
}
