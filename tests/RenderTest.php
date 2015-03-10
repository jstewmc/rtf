<?php

namespace Jstewmc\Rtf;

/**
 * A test suite for the renderer class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class RendererTest extends \PHPUnit_Framework_TestCase
{
	/* !render() */
	
	/**
	 * render() should recursively render each group
	 */
	public function testRender()
	{
		$root = (new Element\Group())
			->appendChild(new Element\Text('foo '))
			->appendChild((new Element\Group())
				->appendChild(new Element\Control\Word\B())
				->appendChild(new Element\Text('bar'))
				->appendChild(new Element\Control\Word\B(0))
			);

		$this->assertFalse($root->getIsRendered());

		$renderer = new Renderer();
		$root = $renderer->render($root);
		
		$this->assertTrue($root instanceof Element\Group);
		$this->assertTrue($root->getIsRendered());
		$this->assertTrue($root
			->getLastChild()
			->getChild(1)
			->getStyle()
			->getCharacter()
			->getIsBold()
		);
		
		return;
	}	
}
