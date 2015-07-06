<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxds" control word
 *
 * The "\cxds" control word deletes the previous space (i.e., "CX Delete Space").
 *
 * For example:
 *
 *     {\*\cxs -G}\cxds ing
 *
 * The example above is the suffix "ing".
 *
 * The "\cxds" control word is not an ignored control word.
 *
 * The RTF-CRE specification is ambiguous as to the proximity of the control word and
 * the text it affects. I assume the text element and the control word may be 
 * separated by any number of other elements, but they must appear in the same group.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 */
class Cxds extends Word
{
	/* !Public methods */
	
	/**
	 * Runs the command
	 *
	 * @return  void
	 */
	public function run()
	{
		// if the control word as a previous text element
		if (null !== ($text = $this->getPreviousText())) {
			// if the last character in the text element's text is the space character
			if (substr($text->getText(), -1, 1) == ' ') {
				// remove it
				$text->setText(substr($text->getText(), 0, -1));
			}
		}
		
		return;
	}
}
