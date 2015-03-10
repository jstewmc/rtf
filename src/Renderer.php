<?php

namespace Jstewmc\Rtf;

/**
 * A rendered
 *
 * A renderer renders the parse tree into the document tree.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Renderer
{
	/**
	 * Renders the parse tree into a document
	 *
	 * @param  Jstewmc\Rtf\Element\Group  $root  the parse tree's root group
	 * @return  Jstewmc\Rtf\Element\Group  the render tree's root group
	 * @since  0.1.0
	 */
	public function render(Element\Group $root)
	{
		// create a new, blank style
		$style = new Style();
		
		// render the root and its branches, recursively
		$root->setStyle($style);
		$root->render();
		
		return $root;
	}	
}
