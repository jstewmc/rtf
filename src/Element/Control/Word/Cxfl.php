<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxfl" control word
 *
 * The "\cxfl" control word lower-cases the next letter (e.g., cx Force Lower).
 *
 * For example:
 *
 *     {\*\cxs PH-R}M\cxfl cKinnon
 *
 * The example above would print "McKinnon".
 *
 * The "\cxfl" control word is not an ignored control word.
 *
 * The RTF-CRE specification is ambiguous as to the proximity of the control word and
 * the text it affects. I assume the text element and the control word may be 
 * separated by any number of other elements, but they must appear in the same group. 
 * 
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
class Cxfl extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		// if the control word has a next text element
		if (null !== ($text = $this->getNextText())) {
			// lower-case the text's first character
			$text->setText(lcfirst($text->getText()));
		}
		
		return;
	}
}