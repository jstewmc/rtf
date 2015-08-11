<?php

namespace Jstewmc\Rtf;

/**
 * A Rich Text Format (RTF) snippet
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.4.0
 */
class Snippet extends Element\Group
{
	/* !Magic methods */
	
	/**
	 * Called when the object is constructed
	 *
	 * @param  string|null  $source  the snippet's source
	 * @return  self
	 * @throws  InvalidArgumentException  if $source is not a string
	 * @since  0.4.0
	 */
	public function __construct($source = null) 
	{
		if ($source !== null) {
			$this->read($source);
		}
		
		return;
	}
	
	
	/* !Public methods */
	
	/**
	 * Reads the snippet
	 *
	 * @param  string  $string  the snippet's source code
	 * @return  bool
	 * @throws  InvalidArgumentException  if $string is not a string
	 * @since  0.4.0
	 */
	public function read($string)
	{
		if ( ! is_string($string)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, string, to be a string"
			);	
		}
		
		// fake the snippet as a "root" group
		$string = '{'.$string.'}';
		
		// instantiate the string's chunker and stream
		$chunker = new \Jstewmc\Chunker\Text($string);
		$stream  = new \Jstewmc\Stream\Stream($chunker);	
		
		// lex the stream
		$tokens  = (new Lexer())->lex($stream);
		
		// parse and render the tokens
		$group = (new Renderer())->render((new Parser())->parse($tokens));
		
		// set the snippet's properties from the group
		$this->parent     = null;
		$this->children   = $group->getChildren();
		$this->style      = $group->getStyle();
		$this->isRendered = true;
		
		return (bool) $group;
	}
	
	
	/**
	 * Writes the snippet to a string
	 *
	 * @param  string  $format  the desired format (possible values are "rtf",
	 *     "text", and "html") (optional; if omitted, defaults to "rtf")
	 * @return  string
	 * @throws  InvalidArgumentException  if $format is not a string
	 * @since  0.4.0
	 */
	public function write($format = 'rtf')
	{
		if ( ! is_string($format)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, format, to be a string"
			);
		}
		
		// get the snippet (which is posing as a group) as a string
		$string = (new Writer())->write($this, $format);
		
		// if the format is "rtf", remove the group-open and group-close we added
		if ($format === 'rtf') {
			$string = substr($string, 1, -1);	
		}
		
		return $string;
	}
}
