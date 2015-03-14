<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * The hyphen control symbol ("\-")
 *
 * The hyphen control symbol inserts an optional hyphen
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Hyphen extends Symbol
{
	/* !Protected properties */
	
	/**
	 * @var  string  the control symbol's symbol
	 * @since  0.1.0
	 */
	protected $symbol = '-';
	
	
	/* !Protected methods */
	
	/**
	 * Returns this control symbol as an html string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toHtml()
	{
		return $this->toText();
	}
	
	/**
	 * Returns this control symbol as plain text
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toText()
	{
		return '-';
	}
}
