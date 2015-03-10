<?php

namespace Jstewmc\Rtf\State;

/**
 * A section state
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Section extends State
{
	/* !Protected properties */
	
	/**
	 * @var  int  the section index
	 * @since  0.1.0
	 */
	protected $index = 0;
	
	
	/* !Get methods */
	
	/**
	 * Gets the section index
	 *
	 * @return  int
	 * @since  0.1.0
	 */
	public function getIndex()
	{
		return $this->index;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the section index
	 *
	 * @param  int  $index  the section index
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIndex($index)
	{
		$this->index = $index;
		
		return;
	}

}
