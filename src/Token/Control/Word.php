<?php

namespace Jstewmc\Rtf\Token\Control;

/**
 * A control word token
 *
 * A control word is a specially-formatted command used to perform actions in an
 * RTF document such as: insert special characters, change destination, and set
 * paragraph- or character-formatting. 
 *
 * A control word takes the following form:
 *
 *     \<word>[<delimiter>]
 *
 * The <word> is a string of alphabetic characters. RTF is case-sensitive, and all
 * RTF control words are lowercase. A control word must be shorter than 32
 * characters.
 *
 * The <delimiter> can be one of the following:
 *
 *     A space (" ")
 *         The space is considered part of the control word and does not appear in 
 *         the document. However, any characters following the space, including 
 *         spaces, will appear in the document. 
 *     
 *     A digit or hyphen ("-")
 *         A digit or hyphen indicates a numeric parameter follows. The subsequent
 *         digital sequence is then delimited by a space or any other character 
 *         besides a letter or digit. The parameter can be a positive or negative
 *         number, generally between -32,767 and 32,767. However, readers should
 *         accept any arbitrary string of digits as a legal parameter.
 *
 *     Any character besides a letter or digit
 *         In this case, the delimiting character terminates the control word, but
 *         is not part of the control word.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Word extends Control
{
	/* !Protected properties */
	
	/**
	 * @var  int  the control word's numeric parameter
	 * @since  0.1.0
	 */
	protected $parameter;
	
	/**
	 * @var  string  the control word's word
	 * @since  0.1.0
	 */
	protected $word;
	

	/* !Get methods */
	
	/**
	 * Gets the token's parameter
	 *
	 * @return  int
	 * @since  0.1.0
	 */
	public function getParameter()
	{
		return $this->parameter;
	}
	
	/**
	 * Gets the token's word
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function getWord()
	{
		return $this->word;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the token's parameter
	 *
	 * @param  int  $parameter  the token's parameter
	 * @return  self
	 * @since  0.1.0
	 */
	public function setParameter($parameter)
	{
		$this->parameter = $parameter;
		
		return $this;
	}
	
	/**
	 * Sets the token's word
	 *
	 * @param  string  $word  the token's word
	 * @return  self
	 * @since  0.1.0
	 */
	public function setWord($word)
	{
		$this->word = $word;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs the object
	 *
	 * @param  string  $word  the control word's command (optional; if omitted, 
	 *     defaults to null)
	 * @param  int  $parameter  the control word's numeric parameter (optional;
	 *     if omitted, defaults to null)
	 * @since  0.1.0
	 */
	public function __construct($word = null, $parameter = null) 
	{
		if (is_string($word)) {
			$this->word = $word;
		}
		
		if (is_numeric($parameter)) {
			$this->parameter = $parameter;
		}
		
		return;
	}
	
	/**
	 * Called when the object is treated as a string
	 *
	 * If this token's word is empty, I'll return an empty string.
	 * 
	 * @return  string
	 * @since  0.2.0
	 */
	public function __toString()
	{
		$string = '';
		
		if ($this->word) {
			$string = "\\{$this->word}{$this->parameter}";
			if ($this->isSpaceDelimited) {
				$string .= ' ';
			}
		}
		
		return $string;
	}
	
	
	/* !Public methods */
	
	/**
	 * Creates a control word token from a stream of characters
	 *
	 * @param  Jstewmc\Stream  $stream  a stream of characters (the current character 
	 *     in $characters must be the backslash character ("\"))
	 * @return  Jstewmc\Rtf\Token\Control\Word|false
	 * @throws  InvalidArgumentException  if the current character in $stream is
	 *     not the backslash character ("\")
	 * @throws  InvalidArgumentException  if the next character in $stream is not
	 *     an alphabetic character
	 * @since  0.1.0
	 * @since  0.2.0  renamed from createFromSource() to createFromStream(); replaced
	 *     argument $characters, an array of characters, to $stream, an instance of
	 *     Jstewmc\Stream
	 */
	public static function createFromStream(\Jstewmc\Stream\Stream $stream) 
	{
		$token = false;
				
		// if a current character exists
		if ($stream->current()) {
			// if the current character is the backslash character
			if ($stream->current() === '\\') {
				// if the next character exists
				if ($stream->next() !== false) {
					// if the now current character is an alphabetic character
					if (ctype_alpha($stream->current())) {
						// get the control word's word
						$word = self::readWord($stream);
						
						// if the current character is a digit or hyphen, get the word's parameter
						if (ctype_digit($stream->current()) || $stream->current() == '-') {
							$parameter = self::readParameter($stream);
						} else {
							$parameter = null;
						}
						
						// create the control word token
						$token = new Word($word, $parameter);
						
						// if the current character is a space delimiter, set the flag; otherwise, 
						//    it is not a space character, and it should not be consumed; it's the 
						//    start of another token; rollback to the previous character to leave
						//    the pointer on the last character of this token
						//
						if ($stream->current() === ' ') {
							$token->setIsSpaceDelimited(true);
						} else {
							$token->setIsSpaceDelimited(false);
							$stream->previous();
						}
					} else {
						throw new \InvalidArgumentException(
							__METHOD__."() expects the next element in parameter one, characters, to "
								. "be an alphabetic character"
						);
					}
				} else {
					// hmmm, do nothing?
				}
			} else {
				throw new \InvalidArgumentException(
					__METHOD__."() expects the current element in parameter one, characters, to "
						. "be the backslash character"
				);	
			}
		}
		
		return $token;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Reads a control word's word from the character stream
	 *
	 * @param  Jstewmc\Stream  $stream  a stream of characters (the current character
	 *     must be a alphabetic character)
	 * @return  string 
	 * @throws  InvalidArgumentException  if the current element in $stream is not
	 *     an alphabetic character
	 * @since  0.1.0
	 * @since  0.2.0  replace argument $characters, an array of characters, with $stream
	 *     an instance of Jstewmc\Stream
	 */
	protected static function readWord(\Jstewmc\Stream\Stream $stream) 
	{
		$word = '';
				
		// if the current character is an alphabetic character
		if (ctype_alpha($stream->current())) {
			// loop through the alphabetic characters and build the word
			while (ctype_alpha($stream->current())) {
				$word .= $stream->current();
				$stream->next();
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects the current element in parameter one, characters, "
					. "to be an alphabetic character"	
			);
		}
		
		return $word;
	}
	
	/**
	 * Reads a control word's parameter from the characters stream
	 *
	 * @param  Jstewmc\Stream  $stream  a stream of characters (the current character
	 *     must be a digit or hyphen)
	 * @return  int
	 * @throws  InvalidArgumentException  if the current character in $stream is
	 *     not a digit or hyphen
	 * @since  0.1.0
	 * @since  0.2.0  replace argument $characters, an array of characters, with $stream
	 *     an instance of Jstewmc\Stream
	 */
	protected static function readParameter(\Jstewmc\Stream\Stream $stream)
	{
		$parameter = '';
		
		// if the current character is a digit or hyphen ("-")
		if (ctype_digit($stream->current()) || $stream->current() == '-') {
			// determine if the parameter is negative
			$isNegative = ($stream->current() == '-'); 
			
			// if the number is negative, consume the hyphen
			if ($isNegative) {
				$stream->next();
			}
			
			// loop through the digits and append them to the parameter
			while (ctype_digit($stream->current())) {
				$parameter .= $stream->current();
				$stream->next();
			} 
						
			// evaluate the parameter's numeric value
			$parameter = +$parameter;
		
			// if the parameter is negative, negate it
			if ($isNegative) {
				$parameter = -$parameter;	
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects the current element in parameter one, characters, "
					. "to be a digit or hyphen"
			);
		}
		
		return $parameter;
	}
}
