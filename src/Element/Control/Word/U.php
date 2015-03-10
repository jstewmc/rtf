<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\u" control word
 *
 * The "\u" control word is used to represent a non-ASCII Unicode character. 
 *
 * The "\u" control word should be followed by a signed integer representing
 * its Unicode codepoint. For the benefit of older programs without Unicode 
 * support, this must be followed by the nearest representation of the character
 * in the specified code page. 
 *
 * The control word "\u0" can be used to indicate that subsequent Unicode escape
 * sequences within the current group do not specify a substitution character.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class U extends Word
{

}
