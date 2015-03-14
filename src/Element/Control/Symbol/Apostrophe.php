<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * The apostrophe control symbol ("\'hh")
 *
 * The apostrophe control symbol is used to represent a non-ASCII character from
 * a Windows Code Page. The two digits "hh" are a hexadecimal value for the given
 * character on the given code page. 
 *
 * The current code page is specified by the "\ansicpg" control word.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Apostrophe extends Symbol
{
	/* !Protected properties */
	
	/**
	 * @var  string  the control symbol's symbol
	 * @since  0.1.0
	 */
	protected $symbol = '\'';
	
	
	/* !Protected methods */
	
	/**
	 * Returns the character as an html string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toHtml()
	{
		// parameter is hexadecimal number
		return "&#x{$this->parameter};";
	}
	
	/**
	 * Returns the character as a plain text string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toText()
	{
		return html_entity_decode($this->toHtml());
	}
}
