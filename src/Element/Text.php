<?php

namespace Jstewmc\Rtf\Element;

/**
 * A plain-text element
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Text extends Element
{
	/* !Protected properties */
	
	/**
	 * @var  string  the text element's text
	 * @since  0.1.0
	 */
	protected $text;
	
	
	/* !Get methods */
	
	/**
	 * Gets this text element's text
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function getText()
	{
		return $this->text;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets this text element's text
	 *
	 * @param  string  $text  the element's text
	 * @since  0.1.0
	 */
	public function setText($text)
	{
		$this->text = $text;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs the object
	 *
	 * @param  string  $text  the text element's text
	 * @return  self
	 * @since  0.1.0
	 */
	public function __construct($text = null)
	{
		if (is_string($text)) {
			$this->text = $text;
		}
		
		return;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Returns this text as an html5 string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function toHtml()
	{
		return htmlspecialchars($this->text, ENT_COMPAT | ENT_HTML5);
	}
	
	/**
	 * Returns this text as an rtf string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function toRtf()
	{
		// escape special characters
		$text = str_replace('\\', '\\\\', $this->text);
		$text = str_replace('{', '\{', $text);
		$text = str_replace('}', '\}', $text);
		
		return "$text";
	}
	
	/**
	 * Returns this text as a plain text string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function toText()
	{
		return $this->text;
	}
}
