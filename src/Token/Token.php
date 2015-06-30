<?php

namespace Jstewmc\Rtf\Token;

/**
 * A lexer token
 *
 * A lexer token represents an object in the RTF language (e.g., a control word,
 * a control symbol, a group-open, a group-close, or a plain-text character).
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

abstract class Token
{
	/* !Magic methods */
	
	/**
	 * Called when the token is treated as a string
	 *
	 * @return  string
	 */
	abstract public function __toString();
}
