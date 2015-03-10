<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\emspace" control word
 *
 * The "\emspace" control word inserts a non-breaking space equal to the width of
 * the character "m" in the current font-size. 
 *
 * Some old RTF writers will add an extra space after the "\emspace" control word
 * to trick readers unaware of "emspace" into parsing a regular space. This reader
 * will interpret that as an "emspace" and a regular space.
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Emspace extends Word
{

}
