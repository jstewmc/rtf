<?php

namespace Jstewmc\Rtf\Element;

/**
 * A group
 *
 * A group consists of text, control words, or control symbols enclosed in brackets
 * ("{" and "}"). The opening brace indicates the start of a group and the closing 
 * brace indicates the end of a group.
 *
 * Formatting within a group affects only the text in that group, and generally, 
 * text within a group inherits the formatting of the parent group. 
 *
 * An RTF file may also include groups for fonts, styles, screen-color, pictures,
 * footnotes, comments (aka, annotations), headers, footers, summary information, 
 * fields, and bookmarks as well as document-, section-, paragraph-, and character-
 * formatting properties.
 *
 * If the font, file, style, screen-color, revision mark, summary-information, or
 * document-formatting groups are included, they must precede the first plain-text
 * character in the document. These groups form the RTF document header.
 *
 * The footnote, comment (aka, annotation), header, and footer groups do not inherit
 * the formatting of their parent group. To ensure that these groups are always 
 * formatted correctly, you should set the formatting of these groups to the default
 * with the "\sectd", "\pard", and "\plain" control words, and then add any desired
 * formatting.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
 
class Group extends Element
{
	/* !Protected properties */
	
	/**
	 * @var  Jstewmc\Rtf\Element[]  an array of this group's child elements
	 * @since  0.1.0
	 */
	protected $children = [];
	
	/**
	 * @var  bool  a flag indicating whether or not the group has been rendered
	 *     (if true, inserting and deleting elements will cause a re-render)
	 * @since  0.1.0
	 */
	protected $isRendered = false;
	
	
	/* !Get methods */
	
	/**
	 * Gets this group's child elements
	 *
	 * @return  Jstewmc\Rtf\Element[]
	 * @since  0.1.0
	 */
	public function getChildren()
	{
		return $this->children;
	}
	
	/**
	 * Gets this group's is rendered flag
	 *
	 * @return  bool
	 * @since  0.1.0
	 */
	public function getIsRendered()
	{
		return $this->isRendered;
	}
	
	
	/* !Set methods */
	
	/**
	 * Sets this group's child elements
	 *
	 * @param  Jstewmc\Rtf\Element[]  $children  an array of child elements
	 * @return  self
	 * @since  0.1.0
	 */
	public function setChildren(Array $children)
	{
		$this->children = $children;
		
		return $this;
	}
	
	/**
	 * Sets this group's is rendered flag
	 * 
	 * @param  bool  $isRendered  a flag indicating whether or not the group has been 
	 *     rendered
	 * @return  self
	 * @since  0.1.0
	 */
	public function setIsRendered($isRendered)
	{
		$this->isRendered = $isRendered;
		
		return $this;
	}
	
	
	/* !Public methods */
	
	/**
	 * Appends a child element to this group
	 *
	 * @param  Jstewmc\Rtf\Element  $element  the element to append
	 * @return  self
	 * @since   0.1.0
	 */
	public function appendChild(Element $element)
	{
		$this->beforeInsert($element);
		
		array_push($this->children, $element);
		
		$this->afterInsert();
		
		return $this;
	}
	
	/**
	 * Returns the child element with $index or null if child does not exist
	 *
	 * @param  int  $index  the index of the desired child element (0-based)
	 * @return  Jstewmc\Rtf\Element|null
	 * @throws  InvalidArgumentException  if $index is not an integer
	 * @throws  OutOfBoundsException      if $index is not an existing key
	 * @since  0.1.0
	 */
	public function getChild($index)
	{
		if (is_numeric($index) && is_int(+$index)) {
			if (array_key_exists($index, $this->children)) {
				return $this->children[$index];
			} else {
				throw new \OutOfBoundsException(
					__METHOD__."() expects parameter one, index, to be a valid key"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, index, to be an integer"
			);
		}
		
		return null;
	}
	
	/**
	 * Returns the element's index in this group's children (if it exists)
	 *
	 * Warning! This method may return a boolean false, but it may also return an
	 * integer value that evaluates to false. Use the strict comparison operator, 
	 * "===" when testing the return value of this method.
	 * 
	 * @param  Jstewm\Rtf\Element\Element  $element  the element to find
	 * @return  int|false
	 */
	public function getIndex(Element $element)
	{
		foreach ($this->children as $k => $child) {
			if ($child === $element) {
				return $k;
			}
		}

		return false;
	}
	
	/**
	 * Returns the group's first child element or null if it doesn't exist
	 *
	 * @return  Jstewmc\Rtf\Element|null
	 * @since  0.1.0
	 */
	public function getFirstChild()
	{
		return count($this->children) > 0 ? reset($this->children) : null;
	}
	
	/**
	 * Returns the group's last child element or null if it doesn't exist
	 *
	 * @return  Jstewmc\Rtf\Element|null
	 * @since  0.1.0
	 */
	public function getLastChild()
	{
		return count($this->children) > 0 ? end($this->children) : null;
	}
	
	/**
	 * Returns the number of children
	 *
	 * @return  int
	 * @since  0.1.0
	 */
	public function getLength()
	{
		return count($this->children);
	}
	
	/**
	 * Returns true if the group has $element, optionally, at $index
	 *
	 * I'll accept one or two arguments. If given both an element and an index, I'll
	 * return true if the element exists at the index. If given an element only, I'll
	 * return true if the element exists at *any* index. If given an index only, I'll
	 * return true if *any* element exists at the index.
	 *
	 * @param  Jstewmc\Rtf\Element|null  $element  the element to test (optional; if
	 *     omitted, defaults to null)
	 * @param  int|null  $index  the index to test (optional; if omitted, defaults to
	 *     null)
	 * @return  bool
	 * @throws  BadMethodCallException    if $element and $index are null
	 * @throws  InvalidArgumentException  if $index is not a number
	 * @since  0.1.0
	 */
	public function hasChild(Element $element = null, $index = null)
	{
		$hasChild = false;
		
		// if $element or $index was passed
		$hasElement = $element !== null;
		$hasIndex   = $index !== null;
		if ($hasElement || $hasIndex) {
			// if $index is null or a valid integer
			if ( ! $hasIndex || (is_numeric($index) && is_int(+$index))) {
				// if we're testing a particular element at a particular index
				// elseif we're testing a particular element at any index
				// elseif we're testing any element at a particular index
				//
				if ($hasElement && $hasIndex) {
					$hasChild = $this->getIndex($element) === $index;
				} elseif ($hasElement) {
					$hasChild = $this->getIndex($element) !== false;
				} elseif ($hasIndex) {
					$hasChild = array_key_exists($index, $this->children) 
						&& ! empty($this->children[$index]);
				}
			} else {
				throw new \InvalidArgumentException(
					__METHOD__."() expects optional parameter two, index, to be an integer"
				);
			}
		} else {
			throw new \BadMethodCallException(
				__METHOD__."() expects one or two parameters"
			);
		}
		
		return $hasChild;
	}
	
	/**
	 * Inserts a child element at $index
	 *
	 * I'll accept a valid key, and insert the element there; a value one higher than
	 * the highest key, and I'll append the element to the end of the array; or, zero, 
	 * and I'll prepend the element to the beginning of the array.
	 *
	 * @param  Jstewmc\Rtf\Element\Element  $element  the child element to insert
	 * @param  int                          $index    the child's index
	 * @return  self
	 * @throws  InvalidArgumentException  if $index is not a numeric index
	 * @throws  OutOfBoundsException      if $index is not a valid key; one higher than
	 *     the highest key; or, zero
	 * @since  0.1.0
	 */
	public function insertChild(Element $element, $index)
	{
		// if $index is an integer
		if (is_numeric($index) && is_int(+$index)) {
			// if index is a valid key
			if (array_key_exists($index, $this->children)) {
				$this->beforeInsert($element);
				array_splice($this->children, $index, 0, [$element]);
				$this->afterInsert();
			} elseif ($index == count($this->children)) {
				$this->appendChild($element);
			} elseif ($index == 0) {
				$this->prependChild($element);
			} else {
				throw new \OutOfBoundsException(
					__METHOD__."() expects parameter two, index, to be a valid key; one higher"
						. "than the highest key; or, zero"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter two, index, to be an integer"
			);
		}
		
		return $this;
	}
	
	/**
	 * Renders the group 
	 *
	 * @return  void
	 */
	public function render()
	{
		// set the group's render flag to false
		$this->isRendered = false;
		
		// loop through the group's children
		foreach ($this->children as $k => $child) {
			// get the child's (starting) style...
			//
			// if this child is the first-child, it inherits the group's style; otherwise, 
			//     it inherits the previous child's (ending) style
			//
			if ($k == 0) {
				$style = $this->style;
			} else {
				$previous = $this->children[$k - 1];
				$style = $previous->getStyle();
			}
			
			// set the child's style...
			//
			// be sure to clone the style to create a distinct copy of the child's state;
			//     otherwise, changes to the child's state will affect the group's state,
			//     and the group's (ending) state will be the last child's (ending) state
			//
			$child->setStyle(clone $style);
			
			// if the child is a group, render it
			// otherwise, if the child is a control word or symbol, run it
			//
			if ($child instanceof Group) {
				$child->render();
			} elseif ($child instanceof Control\Control) {
				$child->run();
			}
			
			// finally, merge the (ending) state of the current child with the (ending)
			//     state of the previous sibling (to save memory)
			//	
			$child->getStyle()->merge($style);
		}
		
		// set the group's flag to true
		$this->isRendered = true;
		
		return;
	}
	
	/**
	 * Prepends a child element to the group
	 *
	 * @param  Jstewmc\Rtf\Element  $element  the child element to prepend
	 * @return  self
	 * @since  0.1.0
	 */
	public function prependChild(Element $element)
	{
		$this->beforeInsert($element);
		
		array_unshift($this->children, $element);
		
		$this->afterInsert();
		
		return $this;
	}
	
	/**
	 * Removes a child from the parent (and returns it)
	 *
	 * @param  Jstewmc\Rtf\Element|int  $element  the child element or integer index 
	 *     to remove
	 * @return  Jstewmc\Rtf\Element|null  the removed element
	 * @throws  InvalidArgumentException  if $index is not an intger
	 * @throws  OutOfBoundsException      if $index is not an existing key
	 * @since  0.1.0
	 */
	public function removeChild($element)
	{
		$removed = null;
		
		// if $element is an integer or element
		$isInteger = is_numeric($element) && is_int(+$element);
		$isElement = $element instanceof Element;
		if ($isInteger || $isElement) {
			// get the element's index
			if ($isElement) {
				$index = $this->getIndex($element);
			} else {
				$index = $element;
			}
			// if the index exists
			if ($index !== false && array_key_exists($index, $this->children)) {
				$this->beforeDelete();
				$removed = reset(array_splice($this->children, $index, 1));
				$this->afterDelete($removed);
			} else {
				throw new \OutOfBoundsException(
					__METHOD__."() expects parameter one, element, to be a valid child element or key"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, index, to be an integer or element instance"
			);
		}
		
		return $removed;
	}
	
	/**
	 * Replaces the the $old with $new (and returns replaced element)
	 *
	 * @param  Jstewmc\Rtf\Element|int  $old  the element to be replaced or an integer 
	 *     index
	 * @param  Jstewmc\Rtf\Element      $new  the replacement element
	 * @return  self
	 * @throws  InvalidArgumentException  if $index is not an integer or element
	 * @throws  OutOfBoundsException      if $index is not an existing key or child 
	 *     element
	 * @since  0.1.0
	 */
	public function replaceChild($old, Element $new) 
	{
		$replaced = null;
		
		// if $old is an integer or element
		$isInteger = is_numeric($old) && is_int(+$old);
		$isElement = $old instanceof Element;
		if ($isInteger || $isElement) {
			// get the element's index
			if ($isElement) {
				$index = $this->getIndex($old);
			} else {
				$index = $old;
			}
			// if the index exists
			if ($index !== false && array_key_exists($index, $this->children)) {
				$this->beforeInsert($new);
				$replaced = reset(array_splice($this->children, $index, 1, [$new]));		
				$this->afterDelete($replaced);		
			} else {
				throw new \OutOfBoundsException(
					__METHOD__."() expects parameter two, index, to be a valid key or child element"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter two, index, to be an integer or element"
			);
		}
		
		return $replaced;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Called after an element is inserted
	 * 
	 * @return  void
	 * @since  0.1.0
	 */
	protected function afterInsert()
	{
		if ($this->isRendered) {
			$this->render();
		}
		
		return;
	}
	
	/**
	 * Called after an element is deleted
	 *
	 * @param  Jstewmc\Rtf\Element\Element  $element  the deleted element
	 * @return  void
	 * @since  0.1.0
	 */
	protected function afterDelete($element)
	{
		$element->setParent(null);
		
		if ($this->isRendered) {
			$this->render();
		}
		
		return;
	}
	
	/**
	 * Called before an element is deleted
	 *
	 * @return  void
	 * @since  0.1.0
	 */
	protected function beforeDelete()
	{
		return;
	}
	
	/**
	 * Called before an element is inserted
	 *
	 * @param  Jstewmc\Rtf\Element\Element  $element  the element to be inserted
	 * @return  void
	 * @since  0.1.0
	 */
	protected function beforeInsert($element)
	{
		$element->setParent($this);
		
		return;
	}
	
	/**
	 * Returns the group as an html5 string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function toHtml()
	{
		$html = '';
		
		// set the first element's "old" style to the group's style
		$oldStyle = $this->style;
		
		// define a flag indicating whether or not this group is the root group
		//
		// setting this flag here feel a little hackish!
		// however, the first element in the first group is different than the first
		//     element in any other group
		//
		$isFirstGroup = empty($this->parent);
		
		// a flag indicating whether or not the element is the first "textual" element
		//     in the group (i.e., control word with a special symbol, an actual text
		//     element, etc)
		//
		$isFirstTextualElement = true;
		
		// loop through the group's children
		foreach ($this->children as $child) {
			// if the child is a textual element
			$string = $child->format('html');
			if ( ! empty($string)) {
				// get the child's style
				$newStyle = $child->getStyle();
				// if the child is the first textual element in the first (aka, "root") group
				if ($isFirstGroup && $isFirstTextualElement) {
					// open the document's first section, paragraph, and character tags
					$html .= '<section style="'.$newStyle->getSection()->format('css').'">'
						 . '<p style="'.$newStyle->getParagraph()->format('css').'">'
						 . '<span style="'.$newStyle->getCharacter()->format('css').'">';
					// set the flag to false
					$isFirstTextualElement = false;
				} else {
					// otherwise, the child is not the first textual element in the root group 
					//    and we only close and open the section, paragraph, and character tags
					//    if the style has changed between elements
					//
					// keep in mind, a section takes precedence over a paragraph and a character;
					//     a paragraph takes precedence over a character; so on and so forth
					//
					if ($oldStyle->getSection() != $newStyle->getSection()) {
						$html .= '</span></p></section>'
							. '<section style="'.$newStyle->getSection()->format('css').'">'
							. '<p style="'.$newStyle->getParagraph()->format('css').'">'
							. '<span style="'.$newStyle->getCharacter()->format('css').'">';
					} elseif ($oldStyle->getParagraph() != $newStyle->getParagraph()) {
						$html .= '</span></p>'
							. '<p style="'.$newStyle->getParagraph()->format('css').'">'
							. '<span style="'.$newStyle->getCharacter()->format('css').'">';
					} elseif ($oldStyle->getCharacter() != $newStyle->getCharacter()) {
						$html .= '</span>'
							. '<span style="'.$newStyle->getCharacter()->format('css').'">';
					}
				}
				
				// append the html string
				$html .= $string;
				
				// set the "old" style to the current element's style for the next iteration
				$oldStyle = $newStyle;
			}
		}
		
		return $html;
	}
	
	/**
	 * Returns the group as an rtf string
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function toRtf()
	{
		$rtf = '{';
		
		foreach ($this->children as $child) {
			$rtf .= $child->format('rtf');
		} 

		$rtf .= '}';
		
		return $rtf;
	}
	
	/**
	 * Returns the group as plain text
	 *
	 * @return  string
	 * @since  0.1.0
	 */
	public function toText()
	{
		$text = '';
		
		foreach ($this->children as $child) {
			$text .= $child->format('text');
		}
		
		return $text;
	}
}
