<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\enspace" control word
 *
 * The "\enspace" control word inserts a non-breaking space equal to the width of
 * the character "n" in the current font-size. 
 *
 * Some old RTF writers will add an extra space after the "\enspace" control word
 * to trick readers unaware of "enspace" into parsing a regular space. This reader
 * will interpret that as an "enspace" and a regular space.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Enspace extends Word
{

}
