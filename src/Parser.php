<?php

namespace Jstewmc\Rtf;

/**
 * A Rich Text Format (RTF) parser
 *
 * A Rich Text Format (RTF) parser parses an array of tokens into the document's 
 * parse tree.
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */

class Parser 
{
	/* !Protected methods */
	
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
	
	
	/* !Public methods */
	
	/**
	 * Parses tokens into a parse tree
	 *
	 * @param  Jstewmc\Rtf\Token[]  $tokens  an array of tokens to parse
	 * @return  Jstewmc\Rtf\Element\Group|null  the parse tree's root group (or
	 *     null if $tokens is an empty array)
	 * @since  0.1.0
	 */
	public function parse(Array $tokens)
	{	
		$root  = null;
		
		// loop through the tokens
		$stack = new \SplStack();
		foreach ($tokens as $token) {
			// if the token is a group-open token
			if ($token instanceof Token\Group\Open) {
				$this->parseGroupOpen($token, $stack, $root);
				if ($root === null) {
					$root = $stack->bottom();
				}
			} else {
				// if a root group has been opened
				if ($root !== null) {
					if ($token instanceof Token\Group\Close) {
						$this->parseGroupClose($token, $stack);
					} elseif ($token instanceof Token\Control\Word) {
						$this->parseControlWord($token, $stack->top());
					} elseif ($token instanceof Token\Control\Symbol) {
						$this->parseControlSymbol($token, $stack->top());
					} elseif ($token instanceof Token\Text) {
						$this->parseText($token, $stack->top());
					}
				}
			}
		}
		
		return $root;
	}
	
	
	/* !Protected methods */
	
	/**
	 * Parses a control symbol token
	 * 
	 * @param  Jstewnc\Rtf\Token\Control\Symbol $token  the control symbol token
	 * @param  Jstewmc\Rtf\Element\Group        $group  the current group
	 * @return  void
	 * @since  0.1.0
	 */
	protected function parseControlSymbol(Token\Control\Symbol $token, Element\Group $group) 
	{	
		// if a class exists for the symbol, instantiate it; otherwise, instantiate 
		//     a generic control symbol element
		// keep in mind, class_exists() requires a fully-qualified namespace
		// 
		if (array_key_exists($token->getSymbol(), self::$symbols)) {
			// get the symbol's name
			$name = self::$symbols[$token->getSymbol()];
			$name = ucfirst($name);
			$classname = "Jstewmc\\Rtf\\Element\\Control\\Symbol\\$name";
			if (class_exists($classname)) {
				$symbol = new $classname();	
			} else {
				$symbol = new Element\Control\Symbol\Symbol();
				$symbol->setSymbol($token->getSymbol());
			}
		} else {
			$symbol = new Element\Control\Symbol\Symbol();
			$symbol->setSymbol($token->getSymbol());	
		}
				
		// set the symbol's parameter
		$symbol->setParameter($token->getParameter());
		$symbol->setIsSpaceDelimited($token->getIsSpaceDelimited());
		
		// append the element
		$symbol->setParent($group);
		$group->appendChild($symbol);
		
		return;
	}
	
	/**
	 * Parses a control word token
	 *
	 * @param  Jstewmc\Rtf\Token\Control\Word  $token  the control word token
	 * @param  Jstewmc\Rtf\Element\Group       $group  the current group
	 * @return  void
	 * @since   0.1.0
	 */
	protected function parseControlWord(Token\Control\Word $token, Element\Group $group) 
	{
		// if a class exists for the control word
		$filename  = ucfirst($token->getWord());
		$classname = "Jstewmc\\Rtf\\Element\\Control\\Word\\$filename"; 
		if (class_exists($classname)) {
			// instantiate the control word element and break
			$word = new $classname();
		} else {
			// otherwise, instantiate a generic control word
			$word = new Element\Control\Word\Word();
			$word->setWord($token->getWord());
		}
		
		// set the element's parameter
		$word->setParameter($token->getParameter());
		$word->setIsSpaceDelimited($token->getIsSpaceDelimited());
		
		// append the element
		$word->setParent($group);
		$group->appendChild($word);
				
		return;	
	}
	
	/**
	 * Parses a group-close token
	 *
	 * @param  Jstewmc\Rtf\Token\Group\Close  $token  the group-close token
	 * @param  SplStack                       $stack  the group stack
	 * @return  void
	 * @since  0.1.0
	 */
	protected function parseGroupClose(Token\Group\Close $token, \SplStack $stack)
	{
		$stack->pop();
		
		return;
	}
	
	/**
	 * Parses a group-open token
	 *
	 * @param  Jstewmc\Rtf\Token\Group\Open  $token  the group-open token
	 * @param  SplStack                      $stack  the group stack
	 * @param  Jstewmc\Rtf\Element\Group     $root   the root group (optional; if 
	 *     omitted, defaults to null)
	 * @return  void
	 * @since  0.1.0
	 */
	protected function parseGroupOpen(Token\Group\Open $token, \SplStack $stack) 
	{
		$group = new Element\Group();
		
		// if the group is not the root
		if ($stack->count() > 0) {
			// set the parent-child and child-parent relationships
			$group->setParent($stack->top());
			$stack->top()->appendChild($group);
		}
		
		$stack->push($group);
		
		return;
	}
	
	/**
	 * Parses a text token
	 *
	 * @param  Jstewmc\Rtf\Token\Text     $token  a text token
	 * @param  Jstewmc\Rtf\Element\Group  $group  the current group
	 * @return  void
	 * @since  0.1.0
	 */
	protected function parseText(Token\Text $token, Element\Group $group) 
	{		
		$text = new Element\Text($token->getText());
		
		$text->setParent($group);
		$group->appendChild($text);
		
		return;
	}
}
