<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\chdpl" control word
 *
 * The "\chdpl" control word inserts the current date in abbreviated format (e.g.,
 * "Thu, Jul 22, 2015").
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Chdpl extends Word
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
		return (new \DateTime('now'))->format('D, j M Y');
	}
}
