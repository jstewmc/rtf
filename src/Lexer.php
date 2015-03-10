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
	 * @param  string  $source  the source code to lex
	 * @return  Jstewmc\RtfLexer\Token[]  an array of tokens
	 * @throws  InvalidArgumentException  if $source is not a string
	 */
	public function lex($source)
	{	
		$tokens = [];
		
		// if $source is a string
		if (is_string($source)) {
			// if $source is not empty
			if ( ! empty($source)) {
				// loop through the characters
				$characters = str_split($source);
				do {
					// if the current character is not an ignored character
					if ( ! in_array(current($characters), ["\n", "\r", "\f", "\0"])) {
						// switch on the current character
						switch (current($characters)) {
							
							case '{':
								$token = new Token\Group\Open();
								break;
							
							case '}':
								$token = new Token\Group\Close();
								break;
							
							case '\\':
								// if the next character exists
								$key = key($characters) + 1;
								if (array_key_exists($key, $characters)) {
									// the next character may be a literal character, an escaped new-line or 
									//     carriage-return (i.e., an implicit "\par" control word), a control 
									//     word, or a control symbol
									//
									$next = $characters[$key];
									if (in_array($next, ['\\', '{', '}'])) {
										$token = Token\Text::createFromSource($characters);
									} elseif ($next == "\n" || $next == "\r") {
										$token = new Token\Control\Word('par');
										next($characters);  // consume the current "\" character
									} elseif (ctype_alpha($next)) {
										$token = Token\Control\Word::createFromSource($characters);
									} else {
										$token = Token\Control\Symbol::createFromSource($characters);
									}
								}
								break;
							
							case "\t":
								// tab characters should be converted to "\tab" control words
								$token = new Token\Control\Word('tab');
								break;
							
							default:
								$token = Token\Text::createFromSource($characters);
						}
						
						// if the token was created successfully
						if ($token) {
							$tokens[] = $token;
						}
					}
				} while (next($characters));
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, source, to be a string"
			);
		}
		
		return $tokens;
	}
}
