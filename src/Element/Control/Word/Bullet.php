<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\bullet" control word
 *
 * The "\bullet" control word inserts a bullet character.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Bullet extends Word
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
		return '&bull;';	
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
