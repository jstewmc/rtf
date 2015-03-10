<?php

namespace Jstewmc\Rtf\State;

/**
 * A paragraph state
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Paragraph extends State
{
	/* !Protected properties */
	
	/**
	 * @var  int  the paragraph index
	 * @since  0.1.0
	 */
	protected $index = 0;
	
	
	/* !Get methods */
	
	/**
	 * Gets the paragraph index
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
	 * Sets the paragraph index
	 *
	 * @param  int  $index  the paragraph index
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIndex($index)
	{
		$this->index = $index;
		
		return;
	}
}
