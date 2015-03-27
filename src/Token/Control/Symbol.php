<?php

namespace Jstewmc\Rtf\Token\Control;

/**
 * A control symbol token
 *
 * A control symbol consists of a backslash followed by a single, non-alphabetic 
 * character (aka, a symbol). 
 *
 * A control symbol usually inserts a special character. For example, the control 
 * symbol "\~" represents a non-breaking space.
 * 
 * Generally, control symbols take no delimiters. However, the apostrophe control
 * symbol ("\'") takes a two-digit hexadecimal parameter.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Symbol extends Control
{
	/* !Protected properties */
	
	/**
	 * @var  string  the control symbol's string parameter
	 * @since  0.1.0
	 */
	protected $parameter;
	
	/**
	 * @var  string  the control symbol's symbol
	 * @since  0.1.0
	 */
	protected $symbol;
	
	
	/* !Get methods */
	
	/**
	 * Gets the token's parameter
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function getParameter()
	{
		return $this->parameter;
	}
	
	/**
	 * Gets the token's symbol
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function getSymbol()
	{
		return $this->symbol;
	}
	

	/* !Set methods */
	
	/**
	 * Sets the token's parameter
	 *
	 * @param  string  $parameter  the token's parameter
	 * @return  self
	 * @since  0.1.0
	 */
	public function setParameter($parameter)
	{
		$this->parameter = $parameter;
		
		return $this;
	}
	
	/**
	 * Sets the token's symbol
	 *
	 * @param  string  $symbol  the token's symbol
	 * @return  self
	 * @since  0.1.0
	 */
	public function setSymbol($symbol)
	{
		$this->symbol = $symbol;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs the object
	 *
	 * @param  string  $symbol     the control symbol's symbol character
	 * @param  mixed   $parameter  the control symbol's parameter
	 * @return  self
	 * @since  0.1.0
	 */
	public function __construct($symbol = null, $parameter = null) 
	{
		if (is_string($symbol)) {
			$this->symbol = $symbol;
		}
		
		if ($parameter !== null) {
			$this->parameter = $parameter;
		}
		
		return;
	}
	
	/**
	 * Called when the object is treated as a string
	 *
	 * I'll return an empty string if this token's $symbol is empty.
	 *
	 * @return  string
	 * @since  0.2.0
	 */
	public function __toString()
	{
		$string = '';
		
		if ($this->symbol) {
			$string = "\\{$this->symbol}{$this->parameter}";
			if ($this->isSpaceDelimited) {
				$string .= ' ';
			}
		}
		
		return $string;
	}
	
	
	/* !Public methods */
	
	/**
	 * Creates a control symbol token from stream
	 *
	 * @param  Jstewmc\Stream  $stream  a stream of characters (the current character
	 *     must be the backslash character, and the next character should be non-
	 *     alphanumeric)
	 * @return  Jstewmc\Rtf\Token\Control\Symbol|false
	 * @throws  InvalidArgumentException  if the current character in $stream is
	 *     not a backslash
	 * @throws  InvalidArgumentException  if the next character in $stream is not
	 *     a non-alphanumeric character
	 * @since  0.1.0
	 * @since  0.2.0  renamed from createFromSource() to createFromStream; replaced
	 *     argument $characters, an array of characters, with $stream, an instance 
	 *     of Jstewmc\STream
	 */
	public static function createFromStream(\Jstewmc\Stream\Stream $stream)
	{
		$symbol = false;
		
		// if a current character exists
		if ($stream->current()) {
			// if the current character is a backslash
			if ($stream->current() === '\\') {
				// if the next character exists
				if ($stream->next() !== false) {
					// if the now current character is not alphanumeric
					if ( ! ctype_alnum($stream->current())) {
						// create a new control symbol
						$symbol = new Symbol($stream->current());
						// if the current character is an apostrophe, get the symbol's parameter
						if ($stream->current() === '\'') {
							$parameter = $stream->next() . $stream->next();
							$symbol->setParameter($parameter);
						}
						// if the next character is a space, the control symbol is space-delimited, 
						//     and we should set the flag; otherwise, it's not, and we should rollback
						//     to leave the pointer on the last character in the token (i.e., the
						//     symbol)
						//
						if ($stream->next() === ' ') {
							$symbol->setIsSpaceDelimited(true);	
						} else {
							$symbol->setIsSpaceDelimited(false);
							$stream->previous();
						}
					} else {
						throw new \InvalidArgumentException(
							__METHOD__."() expects the next element in parameter one, characters, to "
								. "be a non-alphanumeric character"
						);
					}
				} else {
					// hmm, do nothing?
				}
			} else {
				throw new \InvalidArgumentException(
					__METHOD__."() expects the current element in parameter one, characters, to "
						. "be the backslash character"
				);
			}
		}
		
		return $symbol;
	}
}
