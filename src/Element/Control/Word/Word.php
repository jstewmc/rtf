<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A control word element
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Word extends \Jstewmc\Rtf\Element\Control\Control
{
	/* !Protected properties */
	
	/**
	 * @var  bool  a flag indicating whether or not the control word should be 
	 *     preceeded by the "ignored" control symbol; defaults to false
	 */
	protected $isIgnored = false;
	
	/**
	 * @var  int  the control word's parameter; the parameters of certain control 
	 *     words (such as bold and italic) have only two states; if the parameter
	 *     is missing or non-zero, it turns on the control word; if the parameter
	 *     is zero, it turns off the control word
	 * @since  0.1.0
	 */
	protected $parameter;
	
	/**
	 * @var  string  the control word's word; defaults to the classname if this 
	 *     property is null on construction
	 * @since  0.1.0
	 */
	protected $word;

	
	/* !Get methods */
	
	/**
	 * Gets the word's is ignored flag
	 *
	 * @return  bool
	 */
	public function getIsIgnored()
	{
		return $this->isIgnored;
	}
	
	/**
	 * Gets the word's parameter
	 *
	 * @return  int
	 * @since  0.1.0
	 */
	public function getParameter()
	{
		return $this->parameter;
	}
	
	/**
	 * Gets the word's word
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function getWord()
	{
		return $this->word;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the control word's isIgnored flag
	 *
	 * @param  bool  $isIgnored  the control word's is-ignored flag
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsIgnored($isIgnored) 
	{
		$this->isIgnored = $isIgnored;
		
		return $this;
	}
	
	/**
	 * Sets the control word's parameter
	 *
	 * @param  int  $parameter  the control word's parameter
	 * @return  self
	 * @since  0.1.0
	 */
	public function setParameter($parameter)
	{
		$this->parameter = $parameter;
		
		return $this;
	}
	
	/**
	 * Sets the control word's word
	 *
	 * @param  string  $word  the control word's word
	 * @return  self
	 * @since  0.1.0
	 */
	public function setWord($word)
	{
		$this->word = $word;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs this object
	 *
	 * @param  mixed  $parameter  the control word's parameter
	 * @return  self
	 */
	public function __construct($parameter = null)
	{
		// if the control word's word isn't set
		if ($this->word === null) {
			// set it to the classname
			$fqns       = explode('\\', get_class($this));
			$this->word = strtolower(end($fqns));
		}
		
		// if parameter was passed
		if ($parameter !== null) {
			$this->parameter = $parameter;
		}
		
		return;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Returns this control word as an rtf string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	protected function toRtf()
	{
		$rtf = '';
		
		// if a word exists
		if ($this->word) {
			// if the word is ignored
			if ($this->isIgnored) {
				// prepend the ignored control symbol
				$rtf = '\\*';
			}
			// append the word and its parameter
			$rtf .= "\\{$this->word}{$this->parameter}";
			// if the word is space-delimited, append the space
			if ($this->isSpaceDelimited) {
				$rtf .= ' ';
			}	
		}
		
		return $rtf;
	}
}
