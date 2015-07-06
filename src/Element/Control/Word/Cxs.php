<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxs" control word
 *
 * The "\cxs" control word indicates an "ignored" steno group. Steno is written as a
 * series of strokes using pure steno notation with forward-slashes between them but
 * no leading- or trailing-slashes. 
 *
 * The valid steno characters, in order, are STKPWHRAO*EUFRPBLGTSDZ. When the number
 * bar is used, the digits 0-9 are valid. Finally, the hyphen (-) and number sign (#)
 * are allowed.
 *
 * A hyphen is used in cases where there may be confusion between initial and final
 * consonants. For instance, to differentiate between the strokes /RBGS and /-RBGS.
 *
 * If the number bar was used in a stroke, the stroke contains a number sign to 
 * indicate that. The number sign may be anywhere within the stroke, but it should
 * probably be at one end or the other. Keep in mind, most steno programs will output
 * the digit when the number bar is used to create a number, but the number sign when
 * the number bar is used to create a stroke (e.g., "/K#").
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
class Cxs extends Word
{
	/* !Protected properties */
	
	/**
	 * @var  bool  the "\cxs" is an ignored control word
	 */
	protected $isIgnored = true;
}
