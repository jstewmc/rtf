<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * The "\cxstit" control word
 *
 * The "\cxstit" control word indicates a group of stitched text (i.e., "CX STITched").
 *
 * For example:
 *
 *     {\cxstit {\*\cxs PHFPLT}M\_{\*\cxs HFPLT}H\_{\*\cxs SFPLT}S}
 *
 * The example above would be displayed at "M-H-S" with non-breaking hyphens.
 *
 * The "\cxstit" control word is not an ignored command group. 
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 */
class Cxstit extends Word
{
	// nothing yet	
}
