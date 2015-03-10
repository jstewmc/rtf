<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\sub" control word
 *
 * The "\sub" control word subscripts text and shrinks font-size according to font
 * information. 
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Sub extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getCharacter()->setIsSubscript((bool) $this->parameter);
		
		return;
	}
}
