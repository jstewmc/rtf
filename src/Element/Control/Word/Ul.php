<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\ul" control word
 *
 * The "\ul" control word underlines characters. Keep in mind, the "\ul" control
 * word is turned "off" by the "\ulnone" control word. The "\ul0" control word
 * turns off all underlining for the group.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Ul extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getCharacter()->setIsUnderline(
			$this->parameter === null || (bool) $this->parameter
		);
		
		return;
	}
}
