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
	 * @var  string  the control word's word; defaults to the classname if this 
	 *     property is null on construction
	 * @since  0.1.0
	 */
	protected $word;
	
	/**
	 * @var  int  the control word's parameter; the parameters of certain control 
	 *     words (such as bold and italic) have only two states; if the parameter
	 *     is missing or non-zero, it turns on the control word; if the parameter
	 *     is zero, it turns off the control word
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
		$string = "\\{$this->word}{$this->parameter} ";
		
		// if the control word has a parent and it is the last child remove the space
		if ( ! empty($this->parent) && $this->isLastChild()) {
			$string = substr($string, 0, -1);
		}
		
		return $string;
	}
}
