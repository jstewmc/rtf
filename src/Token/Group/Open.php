<?php

namespace Jstewmc\Rtf\Token\Group;

/**
 * An open group token
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Open extends Group
{
	/* !Public methods */
	
	/**
	 * Called when the object is treated as a string
	 *
	 * @return  string
	 * @since  0.2.0
	 */
	public function __toString()
	{
		return '{';
	}
}
