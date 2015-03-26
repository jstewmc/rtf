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
	 * Returns an array of control words with $word and, optionally, $parameter
	 *
	 * @param  string          $word       the control word's word
	 * @param  int|null|false  $parameter  the control word's integer parameter, 
	 *     null for any parameter, or false for no parameter (optional; if omitted, 
	 *     defaults to null)
	 * @return  Jstewmc\Rtf\Element\Control\Word\Word[]
	 * @throws  InvalidArgumentException  if $word is not a string
	 * @throws  InvalidArgumentException  if $parameter is not a null, false, or number
	 * @since  0.1.0
	 */
	public function getControlWords($word, $parameter = null)
	{
		$words = [];
		
		// if $word is a string
		if (is_string($word)) {
			// if $parameter is null, false, or an integer
			$isNull  = $parameter === null;
			$isFalse = $parameter === false;
			$isInt   = is_numeric($parameter) && is_int(+$parameter);
			if ($isNull || $isFalse || $isInt) {
				// loop through the group's children
				foreach ($this->children as $child) {
					// if the child is a group, call the method recursively
					// otherwise, if the child is a word, check its word and parameter
					//
					if ($child instanceof Group) {
						$words = array_merge($words, $child->getControlWords($word, $parameter));
					} elseif ($child instanceof Control\Word\Word) {
						// if the words match
						if ($child->getWord() == $word) {
							// if the parameter is ignored, correctly undefined or equal, append the child
							$isIgnored   = $parameter === null;
							$isUndefined = $parameter === false && $child->getParameter() === null;
							$isEqual     = $child->getParameter() == $parameter;
							if ($isIgnored || $isUndefind || $isEqual) {
								$words[] = $child;
							}
						}
					}
				}
			} else {
				throw new \InvalidArgumentException(
					__METHOD__."() expects parameter two, parameter, to be false, null, or integer"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, word, to be a string"
			);
		}
		
		return $words;
	}
	
	/**
	 * Returns an array of control symbol elements with $symbol and, optionally,
	 *     $parameter
	 *
	 * @param  string             $symbol     the symbol's symbol
	 * @param  string|null|false  $parameter  the symbol's string parameter; null, 
	 *     any parameter; or, false, no parameter (optional; if omitted, defaults to
	 *     null)
	 * @return  Jstewc\Element\Control\Symbol\Symbol[] 
	 * @throws  InvalidArgumentException  if $word is not a string
	 * @throws  InvalidArgumentException  if $parameter is not a string or null
	 * @since  0.1.0
	 */ 
	public function getControlSymbols($symbol, $parameter = null)
	{
		$symbols = [];
		
		// if $symbol is a string
		if (is_string($symbol)) {
			// if $parameter is null, false, or a string
			if ($parameter === null || $parameter === false || is_string($parameter)) {
				// loop through the group's children
				foreach ($this->children as $child) {
					// if the child is a group, call the method recursively
					// otherwise, if the child is a word, check its word and parameter
					//
					if ($child instanceof Group) {
						$symbols = array_merge($symbols, $child->getControlSymbols($symbol, $parameter));
					} elseif ($child instanceof Control\Symbol\Symbol) {
						// if the words match
						if ($child->getSymbol() == $symbol) {
							// if the parameter is ignored, correctly undefined or equal, append the child
							$isIgnored   = $parameter === null;
							$isUndefined = $parameter === false && $child->getParameter() === null;
							$isEqual     = $child->getParameter() == $parameter;
							if ($isIgnored || $isUndefind || $isEqual) {
								$symbols[] = $child;
							}
						}
					}
				}
			} else {
				throw new \InvalidArgumentException(
					__METHOD__."() expects parameter two, parameter, to be false, null, or string"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one, symbol, to be a string"
			);
		}
		
		return $symbols;
	}
	
	/**
	 * Returns the child's index in this group's children (if it exists)
	 *
	 * Warning! This method may return a boolean false, but it may also return an
	 * integer value that evaluates to false. Use the strict comparison operator, 
	 * "===" when testing the return value of this method.
	 * 
	 * @param  Jstewm\Rtf\Element\Element  $element  the element to find
	 * @return  int|false
	 */
	public function getChildIndex(Element $element)
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
	 * Returns true if the group has the child
	 *
	 * I'll accept one or two arguments: if both an element and an index are given 
	 * (in any order), I'll return true if *the* element exists at the index; if 
	 * only an element is given, I'll return true if the element exists at *any* 
	 * index; and, finally, if only an index is given, I'll return true if *any* 
	 * element exists at the index.
	 *
	 * @param  Jstewmc\Rtf\Element|integer  $one  the element or index to test
	 * @param  Jstewmc\Rtf\Element|integer|null  $two  the element or index to test
	 *     (optional; if omitted, defaults to null)
	 * @return  bool
	 * @throws  InvalidArgumentException  if $one is not an element or integer
	 * @throws  InvalidArgumentException  if $two is not null, an element, or an
	 *     integer
	 * @throws  BadMethodCallException    if an element, and element or both are not
	 *     given
	 * @since  0.1.0
	 */
	public function hasChild($one, $two = null)
	{
		$hasChild = false;
		
		// if the first argument is an Element or an index
		$isOneElement = $one instanceof Element;
		$isOneIndex   = is_numeric($one) && is_int(+$one);
		if ($isOneElement || $isOneIndex) {
			// if the second argument is null, an Element, or an Index
			$isTwoNull    = $two === null;
			$isTwoElement = $two instanceof Element;
			$isTwoIndex   = is_numeric($two) && is_int(+$two);
			if ($isTwoNull || $isTwoElement || $isTwoIndex) {
				// decide what to do
				if ($isOneElement && $isTwoNull) {
					// return true if *the* element exists at *any* index
					$hasChild = $this->getChildIndex($one) !== false;
				} elseif ($isOneElement && $isTwoIndex) {
					// return true if *the* element exists at *the* index
					$hasChild = $this->getChildIndex($one) === $two;
				} elseif ($isOneIndex && $isTwoNull) {
					// return true if *any* element exists at *the* index
					$hasChild = array_key_exists($one, $this->children) 
						&& ! empty($this->children[$one]);
				} elseif ($isOneIndex && $isTwoElement) {
					// return true if *the* element exists at *the* index
					$hasChild = $this->getChildIndex($two) === $one;
				} else {
					throw new \BadMethodCallException(
						__METHOD__."() expects one or two parameters: an element, an index, or both "
							. "(in any order)"
					);
				}
			} else {
				throw new \InvalidArgumentException(
					__METHOD__."() expects parameter two to be null, Element, or integer"
				);
			}
		} else {
			throw new \InvalidArgumentException(
				__METHOD__."() expects parameter one to be an Element or integer"
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
	 * Returns true if this group is a "destination"
	 *
	 * @return  bool
	 * @since  0.1.0
	 */
	public function isDestination()
	{
		return $this->getFirstChild() instanceof Control\Symbol\Asterisk;
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
				$index = $this->getChildIndex($element);
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
				$index = $this->getChildIndex($old);
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
		
		// if this group isn't a destination
		if ( ! $this->isDestination()) {
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
		
		// if this group is not a destination
		if ( ! $this->isDestination()) {
			foreach ($this->children as $child) {
				$text .= $child->format('text');
			}
		}
		
		return $text;
	}
}
