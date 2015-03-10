<?php

namespace Jstewmc\Rtf\Element\Control\Word;

/**
 * A control word element
 *
 * Control words are divided into document-, section-, paragraph-, and character-
 * level control words.
 *
 * The control properties of certain control words (such as bold and italic) have
 * only two states. When such a control word has no parameter (or has a non-zero
 * parameter), it is assumed that the control word turns on the property. When 
 * such a control word has a parameter of "0", it is assumed to turn off the 
 * property.
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
	 * @var  string  the control word's word; defaults to the classname if this 
	 *     property is null on construction
	 * @since  0.1.0
	 */
	protected $word;
	
	/**
	 * @var  int  the control word's parameter; default value varies by child class
	 * @since  0.1.0
	 */
	protected $parameter;

	
	/* !Get methods */
	
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
	
	
	/* !Set methods */
	
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
			$this->word = strtolower(end(explode('\\', get_class($this))));
		}
		
		// if parameter was passed
		if ($parameter !== null) {
			$this->parameter = $parameter;
		}
		
		return;
	}
	
	/**
	 * Called when this object is used as a string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function __toString()
	{
		return "\\{$this->word}{$this->parameter} ";
	}
}
