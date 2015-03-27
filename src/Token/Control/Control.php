<?php

namespace Jstewmc\Rtf\Token\Control;

/**
 * A control word or control symbol token
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

abstract class Control extends \Jstewmc\Rtf\Token\Token
{
	/* !Protected properties */
	
	/**
	 * @var  bool  a flag indicating whether or not the control word or symbol is
	 *     space-delimited (e.g., "\foo \bar" versus "\foo\bar"); defaults to true
	 * @since  0.2.0
	 */
	protected $isSpaceDelimited = true;
	
	
	/* !Get methods */
	
	/**
	 * Gets the control's is-space-delimited flag
	 *
	 * @return  bool
	 * @since  0.2.0
	 */
	public function getIsSpaceDelimited()
	{
		return $this->isSpaceDelimited;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the control's is-space-delimited flag
	 *
	 * @param  bool  $isSpaceDelimited  a flag indicating whether or not the control
	 *     word or symbol is space-delimited
	 * @return  self
	 * @since  0.2.0
	 */
	public function setIsSpaceDelimited($isSpaceDelimited)
	{
		$this->isSpaceDelimited = $isSpaceDelimited;
		
		return $this;
	}
}
