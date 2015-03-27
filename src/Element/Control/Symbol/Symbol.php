<?php

namespace Jstewmc\Rtf\Element\Control\Symbol;

/**
 * A control symbol element
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Symbol extends \Jstewmc\Rtf\Element\Control\Control
{
	/* !Protected properties */
	
	/**
	 * @var  string  the control symbol's parameter; generally, empty, unless the 
	 *     symbol is an apostrophe
	 * @since  0.1.0
	 */
	protected $parameter;

	/**
	 * @var  string  the control symbol's symbol
	 * @since  0.1.0
	 */
	protected $symbol;
	
	/**
	 * @var  string[]  an array of symbol names indexed by symbol character
	 * @since  0.1.0
	 */
	protected static $symbols = [
		'\'' => 'apostrophe',
		'*'  => 'asterisk',
		'-'  => 'hyphen',
		'~'  => 'tilde',
		'_'  => 'underscore'
	];
	
	
	/* !Get methods */
	
	/**
	 * Gets the control symbol's parameter
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function getParameter()
	{
		return $this->parameter;
	}
	
	/**
	 * Gets the control symbol's symbol
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function getSymbol()
	{
		return $this->symbol;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the control symbol's parameter
	 *
	 * @param  string  $parameter  the control symbol's parameter
	 * @return  self
	 * @since  0.1.0
	 */
	public function setParameter($parameter)
	{
		$this->parameter = $parameter;
		
		return $this;
	}
	
	/**
	 * Sets the control symbol's symbol
	 *
	 * @param  string  $symbol  the control symbol's symbol
	 * @return  self
	 * @since  0.1.0
	 */
	public function setSymbol($symbol)
	{
		$this->symbol = $symbol;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs the object
	 *
	 * @param  mixed  $parameter  the control symbol's parameter
	 * @return  self
	 */
	public function __construct($parameter = null)
	{		
		if ($parameter !== null) {
			$this->parameter = $parameter;
		}
		
		return;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Returns the control symbol as an rtf string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function toRtf()
	{
		$rtf = '';
		
		if ($this->symbol) {
			$rtf = "\\{$this->symbol}{$this->parameter}";
			if ($this->isSpaceDelimited) {
				$rtf .= ' ';
			}	
		}
		
		return $rtf;
	}
}
