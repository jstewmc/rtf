<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\pard" control word
 *
 * The "\pard" control word resets to default paragraph properties.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Pard extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getParagraph()->reset();
		
		return;
	}	
}
