<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ulnone" control word
 *
 * The "\ulnone" control word stops underlining characters. 
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Ulnone extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getCharacter()->setIsUnderline(false);
		
		return;
	}
}
