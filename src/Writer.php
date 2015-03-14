<?php

namespace Jstewmc\Rtf;

/**
 * An RTF writer
 *
 * An RTF writer writes the document back to source code.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Writer
{
	/* !Public methods */
	
	/**
	 * Returns the document as a string
	 *
	 * @param  Jstewmc\Rtf\Element\Group  $root    the document's root group
	 * @param  string  $format  the desired format (possible values are 'rtf', 
	 *     'html', and 'text') (optional; if omitted, defaults to 'rtf')
	 * @return  string 
	 * @throws  InvalidArgumentException  if $format is not a string
	 * @throws  InvalidArgumentException  if $format is not 'html', 'rtf', 'text'
	 * @since  0.1.0
	 */
	public function write(Element\Group $root, $format = 'rtf')
	{
		$string = '';
		
		// if $format is a string
		if (is_string($format)) {
			// switch on the format
			switch (strtolower($format)) {
				
				case 'html':
					$string = $root->format('html');
					$string .= '</span></p></section>';
					break;
				
				case 'rtf':
					$string = $root->format('rtf');
					break;
				
				case 'text':
					$string = $root->format('text');
					break;
				
				default:
					throw new \InvalidArgumentException(
						__METHOD__."() expects parameter two, format, to be 'html', 'rtf', or 'text'"
					);
			}	
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter two, format, to be a string"
			);
		}
		
		return $string;
	}
}
