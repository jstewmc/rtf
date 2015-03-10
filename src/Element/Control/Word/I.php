<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\i" control word
 *
 * The "\i" control word italicizes characters. It is a two-state control word.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class I extends Word
{
	/* !Protected properties */
	
	/**
	 * @var  int  the control word's parameter; defaults to 1 (aka, "on")
	 */
	protected $parameter = 1;
	
		
	/* !Public methods */
	
	/**
	 * Runs the control
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getCharacter()->setIsItalic((bool) $this->parameter);
		
		return;
	}
}
