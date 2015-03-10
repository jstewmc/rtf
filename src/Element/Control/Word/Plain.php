<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\plain" control word
 *
 * The "\plain" control word resets the character-formatting properties to their
 * default value (e.g., bold is "off", italic is "off", etc).
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Plain extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getCharacter()->reset();
		
		return;
	}
}
