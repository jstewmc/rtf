<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\tab" control word
 *
 * The "\tab" control word inserts the tab character.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Tab extends Word
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
		// hmmm, what is the HTML equivalent of a tab character?
		// in HTML a tab is just whitespace, how about an emspace?
		//
		return '&emsp;';
	}
	
	/**
	 * Returns this control word as plain text
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toText()
	{
		return "\t";
	}
}
