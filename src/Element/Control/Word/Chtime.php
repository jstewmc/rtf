<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\chtime" control word
 *
 * The "\chtime" control word inserts the current time.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Chtime extends Word
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
		return (new \DateTime())->format('H:i:s');
	}
}
