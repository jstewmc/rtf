<?php
	
namespace Jstewmc\Rtf\State;

/**
 * A state
 *
 * A state is a set of properties about an element. A single element may have
 * hundreds of properties (many of which stay the same element-to-element). 
 *
 * Properties are grouped into document-, section-, paragraph-, and character-
 * states.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class State
{	
	/* !Public methods */
	
	/**
	 * Returns the state as a string
	 *
	 * @format  string  $format  the desired format
	 * @return  string
	 * @since  0.1.0
	 */
	public function format($format)
	{
		return '';
	}
	
	/**
	 * Resets the state to its default settings
	 *
	 * @return  void
	 */
	public function reset()
	{	
		foreach (get_class_vars(get_class($this)) as $property => $default) {
			$this->$property = $default;
		}
		
		return;
	}
}
