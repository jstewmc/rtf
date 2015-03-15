<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\v" control word
 *
 * The "\v" control word hides text. The "\v" control word is a two-state control
 * word.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class V extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getCharacter()->setIsVisible(
			$this->parameter === null || (bool) $this->parameter
		);
		
		return;
	}
}
