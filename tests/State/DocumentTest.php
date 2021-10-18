<?php

namespace Jstewmc\Rtf\State;

/**
 * A test suite for the Document class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class DocumentTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
	{
		return $this->assertEquals('', (new Document())->format('foo'));
	}
}
