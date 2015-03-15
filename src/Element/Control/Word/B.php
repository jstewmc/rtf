<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\b" control word
 *
 * The "\b" control word bolds characters. It is a two-state control word.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class B extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getCharacter()->setIsBold(
			$this->parameter === null || (bool) $this->parameter
		);
		
		return;
	}
}
