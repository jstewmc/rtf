<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\par" control word
 *
 * The "\par" control word creates a new paragraph.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Par extends Word
{
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		$this->style->getParagraph()->setIndex(
			$this->style->getParagraph()->getIndex() + 1
		);
		
		return;
	}
}
