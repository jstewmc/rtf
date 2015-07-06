<?php

namespace Jstewmc\Rtf;

/**
 * A Rich Text Format (RTF) document
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Document
{
	/* !Protected properties */
	
	/**
	 * @var  Jstewmc/Rtf/Element/Group  the document's root group
	 * @since  0.1.0
	 */
	protected $root;
	
	
	/* !Get methods */
	
	/**
	 * Returns the document's root element
	 *
	 * @return  Jstewmc\Rtf\Element\Group
	 * @since  0.1.0
	 */
	public function getRoot()
	{
		return $this->root;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the document's root element
	 *
	 * @param  Jstewmc\Rtf\Element\Group
	 * @return  self
	 * @since  0.1.0
	 */
	public function setRoot(Element\Group $root)
	{
		$this->root = $root;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs the object
	 *
	 * If $source string is passed and it starts with a "{" character), I'll attempt 
	 * to read() the source. If $source string is passed and it does not start with 
	 * a "{" character, I'll assume it's a file name and attempt to load it. 
	 * If $source is not passed, I'll instantiate the document's root group.
	 *
	 * @param  string  $source  a file name (must not start with "{" character) or
	 *     an RTF string (must start with "{" character) (optional; if omitted, 
	 *     defaults to null)
	 * @since  0.1.0
	 */
	public function __construct($source = null)
	{
		if (is_string($source)) {
			if (substr($source, 0, 1) === '{') {
				$this->read($source);
			} else {
				$this->load($source);
			}
		} else {
			$this->root = new Element\Group();
		}
		
		return;
	}
	
	/**
	 * Called when the document is treated as a string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function __toString()
	{
		return $this->write();
	}
	
	
	/* !Public methods */
	
	/**
	 * Creates a document from a file
	 *
	 * @param  string  $source  the source's file name
	 * @return  bool  true on success or false on failure
	 * @throws  InvalidArgumentException  if $source is not a string
	 * @throws  InvalidArgumentException  if $source does not exist or is not readable
	 * @since  0.1.0
	 */
	public function load($source)
	{
		// if $source is not a string, short-circuit
		if ( ! is_string($source)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, source, to be a string file name"
			);
		}
		
		// otherwise, create a new file chunker
		$chunker = new \Jstewmc\Chunker\File($source);
		
		return $this->create($chunker);
	}
	
	/**
	 * Creates a document from a string
	 *
	 * @param  string  $string  the source string
	 * @return  bool  true if great success!
	 * @throws  InvalidArgumentException  if $string is not a string
	 * @since  0.1.0
	 */
	public function read($string)
	{
		// if $string is not a string, short-circuit
		if ( ! is_string($string)) {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, string, to, er, be a string"
			);
		}
		
		// otherwise, create a new text chunker
		$chunker = new \Jstewmc\Chunker\Text($string);
		
		return $this->create($chunker);
	}
	
	/**
	 * Saves the document to $destination
	 *
	 * @param  string       $destination  the destination's file name
	 * @param  string|null  $format       the file's format (possible string values 
	 *     are 'html', 'rtf', and 'text') (optional; if omitted, defaults to null 
	 *     and the file's format is assumed from the file name)
	 * @return bool
	 * @throws  InvalidArgumentException  if $destination is not a string
	 * @throws  InvalidArgumentException  if $format is not a string or null
	 * @throws  BadMethodCallException    if $format is null and $destination does
	 *     not end in '.htm', '.html', '.rtf', or '.txt'
	 * @since  0.1.0
	 */
	public function save($destination, $format = null)
	{
		$isSuccess = false;
		
		// if $destination is a string
		if (is_string($destination)) {
			// if $format is null or a string
			if ($format === null || is_string($format)) {
				// if format is null
				if ($format === null) {
					// get the format from the destination's file name
					$period    = strrpos($destination, '.');
					$extension = substr($destination, $period + 1);
					switch (strtolower($extension)) {
						
						case 'htm':
						case 'html':
							$format = 'html';
							break;
						
						case 'rtf':
							$format = 'rtf';
							break;
						
						case 'txt':
							$format = 'text';
							break;
							
						default:
							throw new \BadMethodCallException(
								__METHOD__."() expects parameter one, destination, to end in '.htm', "
									. "'.html', '.rtf', or '.txt' if parameter two, format, is null"
							);
					}
				}
				// put the document's contents
				$isSuccess = (bool) file_put_contents($destination, $this->write($format));
			} else {
				throw new \InvalidArgumentException(
					__METHOD__."() expects parameter two, format, to be 'html', 'rtf', 'text', or null"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, destination, to be a string file name"
			);
		}
		
		return $isSuccess;
	}
	
	/**
	 * Returns the document as a string
	 *
	 * @param  string  $format  the desired format (optional; if omitted, defaults
	 *      to 'rtf')
	 * @return  string
	 * @throws  InvalidArgumentException  if $format is not a string
	 * @since  0.1.0
	 */
	public function write($format = 'rtf')
	{
		$string = '';
		
		// if $format is a string
		if (is_string($format)) {
			$writer = new Writer();
			$string = $writer->write($this->root, $format);	
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, format, to be a string"
			);
		}
		
		return $string;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Creates the document
	 *
	 * If the stream has no tokens, I'll clear the document's root.
	 *
	 * @param  Jstewmc\Chunker\Chunker  $chunker  the document's file or text chunker
	 * @return  bool
	 */
	protected function create(\Jstewmc\Chunker\Chunker $chunker)
	{
		// create the document's stream
		$stream = new \Jstewmc\Stream\Stream($chunker);
		
		// lex the string into tokens
		$lexer = new Lexer();
		$tokens = $lexer->lex($stream);
		
		// if tokens exist
		if ( ! empty($tokens)) {
			// parse the tokens into the parse tree's root group
			$parser = new Parser();
			$group = $parser->parse($tokens);	
			// if a root exists
			if ($group !== null) {
				// render the parse tree's root into the document root
				$renderer = new Renderer();
				$this->root = $renderer->render($group);	
			} else {
				$this->root = null;
			}
		} else {
			$this->root = null;
		}
		
		return (bool) $this->root;
	}
}
