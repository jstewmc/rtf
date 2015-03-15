<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\super" control word
 *
 * The "\super" control word superscripts text and shrinks font-size according 
 * to font information. 
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Super extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getCharacter()->setIsSuperscript(
			$this->parameter === null || (bool) $this->parameter
		);
		
		return;
	}
}
