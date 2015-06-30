<?php

namespace Jstewmc\Rtf\Token;

/**
 * An "other" character token
 *
 * If a character does not belong to a control word, a control symbol, a group-open, 
 * a group-close, or a text token, it's an "other" character. Most often, "other"
 * tokens are carriage-returns, line-feeds, form-feeds, and null characters that are
 * ignored by the lexer.
 * 
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.3.0
 */
class Other extends Token
{
	/* !Protected properties */
	
	/**
	 * @var  string  the "other" character
	 * @since  0.3.0
	 */
	protected $character;
	
	
	/* !Public methods */
	
	/**
	 * Gets the token's character
	 *
	 * @return  string
	 * @since  0.3.0
	 */
	public function getCharacter()
	{
		return $this->character;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the token's character
	 *
	 * @param  string  $character  the "other" character
	 * @return  self
	 * @throws  InvalidArgumentException  if $character is not a string
	 * @since  0.3.0
	 */
	public function setCharacter($character)
	{
		if ( ! is_string($character)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, character, to be a string"
			);
		}
		
		$this->character = $character;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Called when the token is constructed
	 *
	 * @param  string|null  $character  the "other" character (optional; if omitted,
	 *     defaults to null
	 * @return  self
	 * @throws  InvalidARgumentException  if $character is neither a string nor null
	 */
	public function __construct($character = null)
	{
		if ($character !== null) {
			$this->setCharacter($character);
		}
		
		return;
	}
	
	/**
	 * Called when the token is treated like a string
	 *
	 * @return  string
	 */
	public function __toString()
	{
		return "{$this->character}";
	}
}
