<?php

namespace Jstewmc\Rtf;

/**
 * A Rich Text Format (RTF) lexer
 *
 * A Rich Text Format (RTF) lexer converts a stream of RTF source code characters
 * into an array of group-open, group-close, control word, control symbol, and 
 * text tokens. 
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 * @see        http://www.biblioscape.com/rtf15_spec.htm  the RTF 1.5 spec
 */

class Lexer 
{		
	/* !Public methods */
	
	/**
	 * An alias for the lexAll() method
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Rtf\Token\Token[]
	 * @since  0.1.0 
	 */
	public function lex(\Jstewmc\Stream\Stream $stream)
	{	
		return $this->lexAll($stream);
	}
	
	/**
	 * Lexes all tokens from the current stream
	 *
	 * Keep in mind, for very large documents, this may cause a memory overflow.
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Rtf\Token\Token[]
	 * @since  0.2.0
	 */
	public function lexAll(\Jstewmc\Stream\Stream $stream) 
	{
		$tokens = [];
		
		// while tokens exist
		while (false !== ($token = $this->lexOne($stream))) {
			// append le token
			$tokens[] = $token;
		}
		
		return $tokens;
	}
	
	/**
	 * Lexes one token from the current stream
	 *
	 * I'll leave the stream's pointer on the first character after the token's last 
	 * character. For example, if the stream is "\foo bar", I'll leave the stream on
	 * "b" (because the space is part of the control word).
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Rtf\Token\Token|false
	 * @since  0.2.0
	 */
	public function lexOne(\Jstewmc\Stream\Stream $stream)
	{
		$token = false;
		
		// if the stream has characters
		if ($stream->hasCharacters()) {
			// switch on the current character
			switch ($stream->current()) {
				
				case '{':
					$token = $this->lexOpenBracket($stream);
					break;
				
				case '}':
					$token = $this->lexCloseBracket($stream);
					break;
				
				case '\\':
					$token = $this->lexBackslash($stream);
					break;
				
				case "\t":
					$token = $this->lexTab($stream);
					break;
				
				case "\n":
				case "\r":
				case "\f":
				case "\0":
					$token = $this->lexOther($stream);
					break;
				
				default:
					$token = $this->lexText($stream);
			}
			// advance the stream to the next character
			$stream->next();
		}

		return $token;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Lexes the backslash character ("\")
	 *
	 * The backslash character ("\") is arguably the most important character in the
	 * RTF specification. A backslash character can indicate the following:
	 *
	 *     1. a control word (e.g., "\foo")
	 *     2. a control symbol (e.g., "\-")
	 *     3. an escaped special character (e.g., "\\")
	 *     4. an escaped new-line or carriage return (e.g., "\\n")
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Rtf\Token\Token|false
	 * @throws  InvalidArgumentException  if the current character in $stream is not
	 *     the backslash character ("\")
	 * @since  0.2.0
	 */
	protected function lexBackslash(\Jstewmc\Stream\Stream $stream)
	{
		if ($stream->current() !== '\\') {
			throw new \InvalidArgumentExeption(
				__METHOD__."() expects the current character in the stream to be a '\\'"
			);	
		}
		
		// look ahead to the next character, it'll determine what we do; just be sure 
		//     you rollback to the current character
		// 
		$next = $stream->next();
		$stream->previous();
		
		// if a next character exists
		if ($next !== false) {
			// the next character may be a literal character, an escaped new-line or 
			//     carriage-return (i.e., an implicit "\par" control word), a control 
			//     word, or a control symbol
			//
			if (in_array($next, ['\\', '{', '}'])) {
				$token = Token\Text::createFromStream($stream);
			} elseif ($next == "\n" || $next == "\r") {
				$token = new Token\Control\Word('par');
				$stream->next();  // consume the current "\" character
			} elseif (ctype_alpha($next)) {
				$token = Token\Control\Word::createFromStream($stream);
			} else {
				$token = Token\Control\Symbol::createFromStream($stream);
			}
		}
		
		return $token;
	}
	
	/**
	 * Lexes a close-bracket character ("}")
	 *
	 * The close-bracket character indicates the end of a group.
	 * 
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Token\Group\Close  
	 * @throws  InvalidArgumentException  if the current character in $stream is not a
	 *     an close-bracket character ("}")
	 * @since  0.2.0
	 */
	protected function lexCloseBracket(\Jstewmc\Stream\Stream $stream)
	{
		if ($stream->current() !== '}') {
			throw new \InvalidArgumentException(
				__METHOD__."() expects the current character in the stream to be a '}'"
			);
		}
		
		return new Token\Group\Close();
	}
	
	/**
	 * Lexes an open-bracket character ("{")
	 *
	 * The open-bracket character indicates the start of a new group.
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Token\Group\Open  
	 * @throws  InvalidArgumentException  if the current character in $stream is not
	 *     an open-bracket character
	 * @since  0.2.0
	 */
	protected function lexOpenBracket(\Jstewmc\Stream\Stream $stream)
	{
		if ($stream->current() !== '{') {
			throw new \InvalidArgumentException(
				__METHOD__."() expects the current character in the stream to be a '{'"
			);
		}

		return new Token\Group\Open();
	}
	
	/**
	 * Lexes an "other" character
	 *
	 * The RTF source code may include un-escaped carriage-returns ("\r"), un-
	 * escaped line-feeds ("\n"), form feeds ("\f"), and null ("\0") escape 
	 * sequences. These characters are generally ignored by the lexer.
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Token\Other 
	 * @since  0.3.0
	 */
	protected function lexOther(\Jstewmc\Stream\Stream $stream) 
	{
		return new Token\Other($stream->current());
	}
	
	/**
	 * Lexes the tab character ("\t")
	 *
	 * Tab characters should be converted to "\tab" control words.
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Rtf\Token\Control\Word  
	 * @throws  InvalidArgumentException  if the current character in $stream is not
	 *     the tab character
	 * @since  0.2.0
	 */
	protected function lexTab(\Jstewmc\Stream\Stream $stream)
	{
		if ($stream->current() !== "\t") {
			throw new \InvalidArgumentException(
				__METHOD__."() expects the current character in the stream to be a tab character"
			);
		}
		
		return new Token\Control\Word('tab');
	}
	
	/**
	 * Lexes text
	 *
	 * @param  Jstewmc\Stream\Stream  $stream  the character stream
	 * @return  Jstewmc\Rtf\Token\Text
	 * @since  0.2.0
	 */
	protected function lexText(\Jstewmc\Stream\Stream $stream)
	{
		return Token\Text::createFromStream($stream);
	}
}
