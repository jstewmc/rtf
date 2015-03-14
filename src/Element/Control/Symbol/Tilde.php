<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * The tilde control symbol ("\~")
 *
 * The tilde control symbol inserts a non-breaking space
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Tilde extends Symbol
{
	/* !Protected properties */
	
	/**
	 * @var  string  the control symbol's symbol
	 * @since  0.1.0
	 */
	protected $symbol = '~';
	
	
	/* !Protected methods */
	
	/**
	 * Returns this control symbol as an html string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toHtml()
	{
		return '&nbsp;';
	}
	
	/**
	 * Returns this control symbol as plain text
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toText()
	{
		return html_entity_decode('&nbsp;');
	}
}
