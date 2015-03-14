<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\rdblquote" control word
 *
 * The "\rdblquote" control word inserts a right double-quotation mark. 
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Rdblquote extends Word
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
		return '&rdquo;';
	}
	
	/**
	 * Returns this control word as plain text
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toText()
	{
		return html_entity_decode($this->toHtml());
	}
}
