<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * The asterisk control symbol ("\*")
 *
 * The asterisk control symbol marks a destination whose text should be ignored
 * if not understood by the RTF reader. An asterisk control symbol will always be
 * the first control symbol in a destination group.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Asterisk extends Symbol
{
	/* !Protected properties */
	
	/**
	 * @var  string  the control symbol's symbol
	 * @since  0.1.0
	 */
	protected $symbol = '*';
}
