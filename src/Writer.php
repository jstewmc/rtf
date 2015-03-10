<?php

namespace Jstewmc\Rtf;

/**
 * An RTF writer
 *
 * An RTF writer writes the document back to source code.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Writer
{
	/* !Public methods */
	
	/**
	 * Returns the document tree as a string
	 *
	 * @param  Jstewmc\Rtf\Element\Group  $root  the document's root group
	 * @return  string 
	 * @since  0.1.0
	 */
	public function write($root)
	{
		return (string) $root;
	}
}
