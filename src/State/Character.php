<?php

namespace Jstewmc\Rtf\State;

/**
 * A character state
 *
 * A character state defines character-level properties such as formatting, 
 * borders, shading, and visibility.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Character extends State
{
	/* !Protected properties */

	/**
	 * @var  bool  a flag indicating whether or not the characters are bold; defaults
	 *     to false
	 * @since  0.1.0
	 */
	protected $isBold = false;
	
	/**
	 * @var  bool  a flag indicating whether or not the characters are italicized; 
	 *     defaults to false
	 * @since  0.1.0
	 */
	protected $isItalic = false;
	
	/**
	 * @var  bool  a flag indicating whether or not the characters are struckthrough;
	 *     defaults to false
	 * @since  0.1.0
	 */
	protected $isStrikethrough = false;
	
	/**
	 * @var  bool  a flag indicating whether or not the characters are subscript; 
	 *     defaults to false
	 * @since  0.1.0
	 */
	protected $isSubscript = false;
	
	/**
	 * @var  bool  a flag indicating whether or not the characters are superscript;
	 *     defaults to false
	 * @since  0.1.0
	 */
	protected $isSuperscript = false;
	
	/**
	 * @var  bool  a flag indicating whether or not the characters are underlined; 
	 *     defaults to false
	 * @since  0.1.0
	 */
	protected $isUnderline = false;
	
	/**
	 * @var  bool  a flag indicating whether or not the characters are visible;
	 *     defaults to true
	 * @since  0.1.0
	 */
	protected $isVisible = true;
	
	
	/* !Get methods */
	
	/**
	 * Gets the bold flag
	 *
	 * @return  bool
	 * @since  0.1.0
	 */
	public function getIsBold()
	{
		return $this->isBold;
	}
	
	/**
	 * Gets the italic flag
	 *
	 * @return  bool
	 * @since  0.1.0
	 */
	public function getIsItalic()
	{
		return $this->isItalic;
	}
	
	/**
	 * Gets the subscript flag
	 *
	 * @return  bool
	 * @since  0.1.0
	 */
	public function getIsSubscript()
	{
		return $this->isSubscript;
	}
	
	/**
	 * Gets the superscript flag
	 *
	 * @return  bool
	 * @since  0.1.0
	 */
	public function getIsSuperscript()
	{
		return $this->isSuperscript;	
	}
	
	/**
	 * Gets the strikethrough flag
	 *
	 * @return  bool
	 * @since  0.1.0
	 */
	public function getIsStrikethrough()
	{
		return $this->isStrikethrough;
	}
	
	/**
	 * Gets the underline flag
	 *
	 * @return  bool
	 * @since  0.1.0
	 */
	public function getIsUnderline()
	{
		return $this->isUnderline;
	}
	
	/**
	 * Gets the visible flag
	 *
	 * @return  bool
	 * @sicne  0.1.0
	 */
	public function getIsVisible()
	{
		return $this->isVisible;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the bold flag
	 *
	 * @param  bool  $isBold  a flag indicating whether or not the characters are bold
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsBold($isBold)
	{
		$this->isBold = $isBold;
		
		return $this;
	}
	
	/**
	 * Sets the italic flag
	 *
	 * @param  bool  $isItalic  a flag indicating whether or not the characters are italic
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsItalic($isItalic)
	{
		$this->isItalic = $isItalic;
		
		return $this;
	}
	
	/**
	 * Sets the subscript flag
	 *
	 * @param  bool  $isBold  a flag indicating whether or not the characters are subscript
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsSubscript($isSubscript)
	{
		$this->isSubscript = $isSubscript;
		
		return $this;
	}
	
	/**
	 * Sets the superscript flag
	 *
	 * @param  bool  $isSuperscript  a flag indicating whether or not the characters 
	 *     are superscript
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsSuperscript($isSuperscript)
	{
		$this->isSuperscript = $isSuperscript;
		
		return $this;
	}
	
	/**
	 * Sets the strikethrough flag
	 *
	 * @param  bool  $isStrikethrough  a flag indicating whether or not the characters 
	 *      are struckthrough
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsStrikethrough($isStrikethrough)
	{
		$this->isStrikethrough = $isStrikethrough;
		
		return $this;
	}
	
	/**
	 * Sets the underline flag
	 *
	 * @param  bool  $isUnderline  a flag indicating whether or not the characters are 
	 *     underlined
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsUnderline($isUnderline)
	{
		$this->isUnderline = $isUnderline;
		
		return $this;
	}	
	
	/**
	 * Sets the visible flag
	 *
	 * @param  bool  $isVisible  a flag indicating whether or not the characters are 
	 *     visible
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsVisible($isVisible)
	{
		$this->isVisible = $isVisible;
		
		return $this;
	}
}
