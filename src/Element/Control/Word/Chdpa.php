<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\chdpa" control word
 *
 * The "\chdpa" control words inserts the current date in long format (e.g., 
 * "Thursday, July 22, 2015").
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Chdpa extends Word
{
	/* !Protected methods */
	
	/**
	 * Returns this control word as an html string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toHtml()
	{
		return $this->toText();
	}
	
	/**
	 * Returns this control word as plain text
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toText()
	{
		return (new \DateTime())->format('l, j F Y');
	}
}
