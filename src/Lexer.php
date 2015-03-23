<?php

namespace Jstewmc\Rtf;

/**
 * A Rich Text Format (RTF) lexer
 *
 * A Rich Text Format (RTF) lexer converts RTF source code into an array of 
 * group-open, group-close, control word, control symbol, and character 
 * tokens.
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
	 * Lexes source code into tokens
	 *
	 * @param  Jstewmc\Stream  $stream  the source code stream
	 * @return  Jstewmc\Rtf\Token[]  an array of tokens
	 */
	public function lex(\Jstewmc\Stream\Stream $stream)
	{	
		$tokens = [];
		
		// while a current character exists
		while ($stream->current()) {
			// if the current character is not an ignored character
			if ( ! in_array($stream->current(), ["\n", "\r", "\f", "\0"])) {
				// switch on the current character
				switch ($stream->current()) {
					
					case '{':
						$token = new Token\Group\Open();
						break;
					
					case '}':
						$token = new Token\Group\Close();
						break;
					
					case '\\':
						// look ahead to the next character, but make sure you rollback to the 
						//     current character
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
						break;
					
					case "\t":
						// tab characters should be converted to "\tab" control words
						$token = new Token\Control\Word('tab');
						break;
					
					default:
						$token = Token\Text::createFromStream($stream);
				}
				
				// if the token was created successfully
				if ($token) {
					$tokens[] = $token;
				}
			}
			// advance to the next character in the stream
			$stream->next();
		}
		
		return $tokens;
	}
}
