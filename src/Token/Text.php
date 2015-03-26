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
	
	/**
	 * Called when the object is treated as a string
	 *
	 * @return  string
	 * @since  0.2.0
	 */
	public function __toString()
	{
		return "{$this->text}";
	}
	
	
	/* !Public methods */
	
	/**
	 * Creates a new text token from a stream
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  a stream of characters
	 * @return  Jstewmc\Rtf\Token\Text|false
	 * @since   0.1.0
	 * @since   0.2.0  renamed from createFromSource() to createFromStream();
	 *     replaced argument $characters, an array of characters, with $stream, an
	 *     instance of Jstewmc\Stream
	 */
	public static function createFromStream(\Jstewmc\Stream\Stream $stream)
	{
		$token = false;
		
		// loop through the characters until a group-open, group-close, control word,
		//     or control symbol occurs and append the plain-text
		//
		$text = '';
		while (false !== ($character = $stream->current())) {
			// if the current characer isn't ignored
			if ( ! in_array($character, ["\n", "\r", "\f", "\0"])) {
				// if the current character is a backslash
				if ($character == '\\') {
					// if the next character exists
					if (false !== ($next = $stream->next())) {
						// if the next character is a control character
						if (in_array($next, ['\\', '{', '}'])) {
							// it's a literal control character
							// ignore the backslash and append the character
							//
							$text .= $next;
						} else {
							// otherwise, the backslash is the start of a control word
							// rollback two characters (i.e., put the pointer on the character before
							//     the control word's backslash)
							//
							$stream->previous();
							$stream->previous();
							break;
						}
					} else {
						// hmmm, do nothing?
					}
				} elseif ($character == '{' || $character == '}') {
					// otherwise, the current group is closing or a sub-group is opening
					// rollback to the previous character (so it isn't consumed)
					//
					$stream->previous();
					break;
				} else {
					// otherwise, it's text!
					$text .= $character;
				}
			}
			// advance to the next character
			$stream->next();
		}
		
		// if $text is not empty, create a new token
		// keep in mind, empty() will consider '0'to be empty, and it's a valid value
		//
		if ( ! empty($text) || $text === '0') {
			$token = new Text($text);	
		}
			
		return $token;
	}
}
