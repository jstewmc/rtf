<?php

namespace Jstewmc\Rtf\Element\Control;

/**
 * A control word or control symbol element
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Control extends \Jstewmc\Rtf\Element\Element
{
	/* !Protected properties */
	
	/**
	 * @var  bool|null  a flag indicating whether or not this control word or symbol
	 *     is delimited by a space; defaults to true
	 */
	protected $isSpaceDelimited = true;
	
	
	/* !Get methods */
	
	/**
	 * Gets the control's is-space-delimited flag
	 *
	 * @return  bool|null
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
	 * @param  bool|null  $isSpaceDelimited  a flag indicating whether or no the control
	 *     is space delimited
	 * @return  self
	 * @since   0.2.0
	 */
	public function setIsSpaceDelimited($isSpaceDelimited)
	{
		$this->isSpaceDelimited = $isSpaceDelimited;
		
		return $this;
	}
	
	/* !Public methods */
	
	/**
	 * Runs the control word or control word
	 *
	 * @return  void
	 * @since  0.1.0
	 */
	public function run()
	{
		return;
	}
}
