<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\chdate" control word
 *
 * The "\chdate" control word inserts the current date.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Chdate extends Word
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
		return (new \DateTime('now'))->format('m.d.Y');
	}
}
