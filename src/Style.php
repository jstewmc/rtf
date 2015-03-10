<?php
	
namespace Jstewmc\Rtf;

/**
 * An element's style
 *
 * An element's style is the combination of its document-, section-, paragraph-,
 * and character-state.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class Style
{
	/* !Protected properties */
	
	/**
	 * @var  Jstewmc\Rtf\State\Character  the element's character state
	 * @since  0.1.0
	 */
	protected $character;
	
	/**
	 * @var  Jstewmc\Rtf\State\Document  the element's document state
	 * @since  0.1.0
	 */
	protected $document;
	
	/**
	 * @var  Jstewmc\Rtf\State\Paragraph  the element's paragraph state
	 * @since  0.1.0
	 */
	protected $paragraph;
	
	/**
	 * @var  Jstewmc\Rtf\State\Section  the element's section state
	 * @since  0.1.0
	 */
	protected $section;
	
	
	/* !Get methods */
	
	/**
	 * Gets the element's character state
	 * 
	 * @return  Jstewmc\Rtf\State\Character
	 * @since  0.1.0
	 */
	public function getCharacter()
	{
		return $this->character;
	}
	
	/**
	 * Gets the element's document state
	 *
	 * @return  Jstewmc\Rtf\State\Document
	 * @since  0.1.0
	 */
	 public function getDocument()
	 {
		 return $this->document;
	 }
	
	/**
	 * Gets the element's paragraph state
	 *
	 * @return  Jstewmc\Rtf\State\Paragraph
	 * @since  0.1.0
	 */
	public function getParagraph()
	{
		return $this->paragraph;
	}
	
	/**
	 * Gets the element's section state
	 *
	 * @return  Jstewmc\Rtf\State\Section
	 * @since  0.1.0
	 */
	public function getSection()
	{
		return $this->section;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets the element's character state
	 *
	 * @param  Jstewmc\Rtf\State\Charater  $character  the element's character state
	 * @return  self
	 * @since  0.1.0
	 */
	public function setCharacter(State\Character $character)
	{
		$this->character = $character;
		
		return $this;
	}
	
	/**
	 * Sets the element's document state
	 *
	 * @param  Jstewmc\Rtf\State\Document  $document  the element's document state
	 * @return  self
	 * @since  0.1.0
	 */
	public function setDocument(State\Document $document)
	{
		$this->document = $document;
		
		return $this;
	}
	
	/**
	 * Sets the element's paragraph state
	 *
	 * @param  Jstewmc\Rtf\State\Paragraph  $paragraph  the element's paragraph state
	 * @return  self
	 * @since  0.1.0
	 */
	public function setParagraph(State\Paragraph $paragraph)
	{
		$this->paragraph = $paragraph;
		
		return $this;
	}
	
	/**
	 * Sets the element's section state
	 *
	 * @param  Jstewmc\Rtf\State\Section  $section  the element's section state
	 * @return  self
	 * @since   0.1.0
	 */
	public function setSection(State\Section $section)
	{
		$this->section = $section;
		
		return $this;
	}
	
	
	/* !Magic methods */
	
	/**
	 * Constructs the object
	 *
	 * I'll instantiate this style's document-, section-, paragraph-, and character-
	 * states.
	 * 
	 * @return  self
	 * @since  0.1.0
	 */
	public function __construct()
	{
		$this->document  = new State\Document();
		$this->section   = new State\Section();
		$this->paragraph = new State\Paragraph();
		$this->character = new State\Character();
		
		return;
	}
	
	/**
	 * Called after the clone keyword
	 *
	 * PHP calls an object's __clone() magic method *after* it performs a shallow
	 * copy on all the objects properties. Any properties that are references (e.g., 
	 * objects) will remain references. 
	 *
	 * I'll clone the document, section, paragraph, and character states to create
	 * a *deep* clone of this style.
	 * 
	 * @return  void
	 * @since  0.1.0
	 */
	public function __clone()
	{
		$this->document  = clone $this->document;
		$this->section   = clone $this->section;
		$this->paragraph = clone $this->paragraph;
		$this->character = clone $this->character;
		
		return;
	}
	
	
	/* !Public methods */
	
	/**
	 * Merges two styles
	 *
	 * Every element has a cloned style object. However, the style will usually 
	 * change very litte element-to-element. Thus, it's a waste of space to have 
	 * hundreds of identical objects in memory.
	 *
	 * I'll merge this style object with $style. If a state is identical between 
	 * the two, I'll set this style's property to reference $style's property.
	 *
	 * @param  Jstewmc\Rtf\Style  $style  the reference style
	 * @return  self
	 * @since  0.1.0
	 */
	public function merge(Style $style)
	{		
		if ($style->getDocument() == $this->document) {
			$this->document = $style->getDocument();
		}
		
		if ($style->getSection() == $this->section) {
			$this->section = $style->getSection();
		}
		
		if ($style->getParagraph() == $this->paragraph) {
			$this->paragraph = $style->getParagraph();
		}
		
		if ($style->getCharacter() == $this->character) {
			$this->character = $style->getCharacter();
		}
		
		return;
	}
}
