<?php

namespace Jstewmc\Rtf\Token;

/**
 * A plain-text token
 *
 * Everything that isn't a group-open, group-close, control word, or control
 * symbol is plain-text.
 *
 * Special characters ("\", "{", and "}") are escaped with a backslash ("\"). 
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Text extends Token
{
	/* !Protected properties */
	
	/**
	 * @var  string  the token's text
	 * @since  0.1.0
	 */
	protected $text;	
	
	
	/* !Get methods */
	
	/**
	 * Gets the token's text
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function getText()
	{
		return $this->text;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the text token's text
	 *
	 * @param  string  $text  the token's text
	 * @return  self
	 * @since  0.1.0
	 */
	public function setText($text)
	{
		$this->text = $text;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs this object
	 *
	 * @param  string  $text  the token's text
	 * @since  0.1.0
	 */
	public function __construct($text = null)
	{
		if (is_string($text)) {
			$this->text = $text;
		}
		
		return;
	}
	
	
	/* !Public methods */
	
	/**
	 * Creates a new text token from source
	 *
	 * @param  string[]  $source  an array of characters
	 * @return  Jstewmc\Rtf\Token\Text|false
	 * @throws  InvalidArgumentException  if $characters is not an array
	 * @since   0.1.0
	 */
	public static function createFromSource(&$characters)
	{
		$text = false;
		
		// if $characters is an array
		if (is_array($characters)) {
			// if $characters is not empty
			if ( ! empty($characters)) {
				// loop through the characters until a group-open, group-close, control word,
				//     or control symbol occurs
				//
				$text = '';
				do {
					// if the current characer isn't ignored
					$character = current($characters);
					if ( ! in_array($character, ["\n", "\r", "\f", "\0"])) {
	 					// if the current character is a backslash
						if ($character == '\\') {
							// if the next character exists
							$key = key($characters) + 1;
							if (array_key_exists($key, $characters)) {
								// if the next character is a control character
								if (in_array($characters[$key], ['\\', '{', '}'])) {
									// it's a literal control character
									// ignore the backslash and append the character
									//
									$text .= next($characters);
								} else {
									// otherwise, the backslash is the start of a control word
									// rollback to the previous character (so it isn't consumed)
									//
									prev($characters);
									break;
								}
							} else {
								// hmmm, do nothing?
							}
						} elseif ($character == '{' || $character == '}') {
							// otherwise, the current group is closing or a sub-group is opening
							// rollback to the previous character (so it isn't consumed)
							//
							prev($characters);
							break;
						} else {
							// otherwise, it's text!
							$text .= $character;
						}
					}
				} while (next($characters));
				
				// if $text is not empty, create a new token
				if ( ! empty($text)) {
					$text = new Text($text);	
				}
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, characters, to be an array"
			);	
		}
			
		return $text;
	}
}
