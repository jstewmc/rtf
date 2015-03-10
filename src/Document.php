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
	 * Loads the document from $source file
	 *
	 * @param  string  $source  the source's file name
	 * @return  bool  true if great success!
	 * @throws  InvalidArgumentException  if $source is not a string
	 * @throws  InvalidArgumentException  if $source does not exist or is not readable
	 * @throws  RuntimeException          if $source cannot be read for some reason
	 * @since  0.1.0
	 */
	public function load($source)
	{
		// if $source is a string
		if (is_string($source)) {
			// if $source exists and is readable
			if (is_readable($source)) {
				// if we can get the file's contents
				if (false !== ($contents = file_get_contents($source))) {
					// read the file's contents
					return $this->read($contents);
				} else {
					throw new \RuntimeException(
						__METHOD__."() failed to get the file's contents for an unknown reason"
					);
				}
			} else {
				throw new \InvalidArgumentException(
					__METHOD__."() expects parameter one, source, to be a readable file"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, source, to be a string file name"
			);
		}
		
		return false;
	}
	
	/**
	 * Reads the document from $string
	 *
	 * @param  string  $string  the source string
	 * @return  bool  true if great success!
	 * @throws  InvalidArgumentException  if $string is not a string
	 * @since  0.1.0
	 */
	public function read($string)
	{
		$isSuccess = false;
		
		// if $string is actually a string
		if (is_string($string)) {
			// if $source isn't an empty string
			if ($string !== '') {
				// lex the string into tokens
				$lexer = new Lexer();
				$tokens = $lexer->lex($string);
				
				// parse the tokens into the parse tree's root group
				$parser = new Parser();
				$group = $parser->parse($tokens);	
				
				// render the parse tree's root into the document root
				$renderer = new Renderer();
				$root = $renderer->render($group);
				
				// great success!
				$this->root = $root;
				$isSuccess = true;
			} else {
				// hmmm, the string was empty, and there is nothing to read
				// well, it's not an error, so return true
				//
				$isSuccess = true;
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, string, to, er, be a string"
			);
		}
		
		return $isSuccess;
	}
	
	/**
	 * Saves the document to $destination
	 *
	 * @param  string  $destination  the destination's file name
	 * @return bool
	 * @throws  InvalidArgumentException  if $destination is not a string
	 * @since  0.1.0
	 */
	public function save($destination)
	{
		if (is_string($destination)) {
			return (bool) file_put_contents($destination, $this->write());	
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, filename, to be a string"
			);
		}
		
		return false;
	}
	
	/**
	 * Returns the document as a string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function write()
	{
		$writer = new Writer();
		$string = $writer->write($this->root);
		
		return $string;
	}
}
