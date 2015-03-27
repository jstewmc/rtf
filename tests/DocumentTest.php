<?php

namespace Jstewmc\Rtf;

/**
 * A test suite for the Document class
 *
 * @author     Jack Clayton
 * @copyright  2015 Jack Clayton
 * @license    MIT
 * @since      0.1.0
 */
class DocumentTest extends \PHPUnit_Framework_TestCase
{
	/* !dataProviders */
	
	public function notAStringProvider()
	{
		return [
			[null],
			[true],
			[1],
			[1.0],
			// ['foo'],
			[[]],
			[new \StdClass()]
		];
	}
	
	public function neitherAStringNorNullProvider()
	{
		return [
			// [null],
			[true],
			[1],
			[1.0],
			// ['foo'],
			[[]],
			[new \StdClass()]
		];
	}
	
	
	/* !getRoot() / setRoot() */
	
	/**
	 * getRoot() and setRoot() should get and set the root, respectively
	 */
	public function testGetSetRoot()
	{
		$root = new Element\Group();
		
		$document = new Document();
		$document->setRoot($root);
		
		$expected = $root;
		$actual   = $document->getRoot();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !__construct() */
	
	/**
	 * __construct() should return document if $source is null
	 */
	public function testConstruct_returnsObject_ifSourceIsNull()
	{
		$document = new Document();
		
		$this->assertTrue($document instanceof Document);
		
		return;
	}
	
	/**
	 * __construct() should read() string if $source starts with open bracket ("{")
	 */
	public function testConstruct_readsString_ifSourceDoesStartWithOpenBracket()
	{
		$document = new Document('{\b foo\b0}');
		
		$this->assertEquals(3, $document->getRoot()->getLength());
		
		return;
	}
	
	/**
	 * __construct() should load() file if $source does not start with open bracket ("{")
	 */
	public function testConstruct_loadsFile_ifSourceDoesNotStartWithOpenBracket()
	{
		$filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'foo.rtf';
		
		file_put_contents($filename, '{\b foo\b0}');
		
		$document = new Document($filename);
		
		try {
			$this->assertEquals(3, $document->getRoot()->getLength());
			unlink($filename);
		} catch (Exception $e) {
			unlink($filename);
			throw $e;
		}
		
		return;
	}
	
	
	/* !__toString() */
	
	/**
	 * __toString() should return a string if elements do not exist
	 */
	public function testToString_returnsString_ifElementsDoNotExist()
	{
		$document = new Document();
		
		$this->assertEquals('{}', (string) $document);
		
		return;
	}
	
	/**
	 * __toString() should return a string if elements do exist
	 */
	public function testToString_returnsString_ifElementDoExist()
	{
		$rtf = '{\b foo\b0}';
		
		$document = new Document();
		$document->read($rtf);
		
		$expected = $rtf;
		$actual   = (string) $document;
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	
	/* !load() */
	
	/**
	 * load() should throw an InvalidArgumentException if $source is not a string
	 *
	 * @dataProvider  notAStringProvider
	 */
	public function testLoad_throwsInvalidArgumentException_ifSourceIsNotAString($source)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$document = new Document();
		$document->load($source);
		
		return;
	}
	
	/**
	 * load() should throw an InvalidArgumentException if $source does not exist or
	 *     is not readable
	 */
	public function testLoad_throwsInvalidArgumentException_ifSourceIsNotReadable()
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'foo.rtf';
	
		$document = new Document();
		$document->load($filename);
		
		return;
	}
	
	/**
	 * load() should return true if 
	 */
	public function testLoad_returnsTrue_ifSuccess()
	{
		$filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'foo.rtf';
		$contents = '{\b foo\b0}';
		
		file_put_contents($filename, $contents);
		
		$document = new Document();
		
		try {
			$this->assertTrue($document->load($filename));
			$this->assertEquals(3, $document->getRoot()->getLength());
			unlink($filename);	
		} catch (Exception $e) {
			unlink($filename);
			throw $e;
		}
		
		return;
	}
	
	
	/* !read() */
	
	/**
	 * read() should throw an InvalidArgumentException if $source is not a string
	 *
	 * @dataProvider  notAStringProvider
	 */
	public function testRead_throwsInvalidArgumentException_ifSourceIsNotAString($source)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$document = new Document();
		$document->read($source);
		
		return;
	}
	
	/**
	 * read() should return true if $source is empty
	 */
	public function testRead_returnsFalse_ifSourceIsEmpty()
	{
		$document = new Document();
		
		$this->assertFalse($document->read(''));
		
		return;
	}
	
	/**
	 * read() should return false if the load fails
	 */
	public function testRead_returnsFalse_ifLoadFails()
	{
		// hmmm, how do we test this?
	}
	
	/**
	 * read() should return true if the load succeeds
	 */
	public function testRead_returnsTrue_ifLoadSucceeds()
	{
		$document = new Document();
		
		$group = (new Element\Group())
			->appendChild(new Element\Control\Word\B())
			->appendChild(new Element\Text('foo'))
			->appendChild((new Element\Control\Word\B(0))->setIsSpaceDelimited(false));
		
		$renderer = new Renderer();
		$root = $renderer->render($group);
		
		$this->assertTrue($document->read('{\b foo\b0}'));
		$this->assertEquals(3, $document->getRoot()->getLength());
		$this->assertEquals($root, $document->getRoot());
		
		return;
	}
	
	
	/* !save() */
	
	/**
	 * save() should throw an InvalidArgumentException if $destination is not a string
	 *
	 * @dataProvider  notAStringProvider
	 */
	public function testSave_throwsInvalidArgumentException_ifDestinationIsNotAString($destination)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$document = new Document();
		$document->save($destination);
		
		return;
	}
	
	/**
	 * save() should throw an InvalidArgumentException if $format is not a string or null
	 *
	 * @dataProvider  neitherAStringNorNullProvider
	 */
	public function testSave_throwsInvalidArgumentException_ifFormatIsNotAString($format)
	{
		$this->setExpectedException('InvalidArgumentException');
		
		$document = new Document();
		$document->save('foo', $format);
		
		return;
	}
	
	/**
	 * save() should throw a BadMethodCallException if $format is null and destination 
	 *     doesn't end in 'html', 'rtf', or 'txt'
	 */
	public function testSave_throwsBadMethodCallException_ifExtensionIsNotValid()
	{
		$this->setExpectedException('BadMethodCallException');
		
		$document = new Document();
		$document->save('foo');
		
		return;
	}
	
	/**
	 * save() should return false if save fails
	 */
	public function testSave_returnsFalse_ifSaveFails()
	{
		// hmmm, how do we test this?
	}
	
	/**
	 * save() should return true if save is successful
	 */
	public function testSave_returnsTrue_ifSaveSucceeds()
	{
		$filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'foo.rtf';
		
		$rtf = '{\b foo\b0}';
		
		$document = new Document();
		$document->read($rtf);
		
		try {
			$this->assertTrue($document->save($filename));
			$this->assertEquals($rtf, file_get_contents($filename));
			unlink($filename);
		} catch (Exception $e) {
			unlink($filename);
			throw $e;
		}
		
		return;
	}
	
	
	/* !write() */
	
	/**
	 * write() should throw InvalidArgumentException if $format is not a string
	 *
	 * @dataProvider  notAStringProvider
	 */
	public function testWrite_throwsInvalidArgumentException_ifFormatIsNotAString($format)
	{
		$this->setExpectedException('InvalidArgumentException');	
		
		$rtf = '{\b foo\b0}';
		
		$document = new Document();
		$document->read($rtf);
		$document->write($format);
		
		return;
	}
	
	/**
	 * write() should return a string if the format is html
	 */
	public function testWrite_returnsString_ifFormatIsHtml()
	{
		$rtf = '{\b foo\b0}';
		
		$document = new Document();
		$document->read($rtf);
		
		$expected = '<section style=""><p style=""><span style="font-weight: bold;">'
			. 'foo</span></p></section>';
		$actual = $document->write('html');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * write() should return a string if the format is rtf
	 */
	public function testWrite_returnsString_ifFormatIsRtf()
	{
		$rtf = '{\b foo\b0}';
		
		$document = new Document();
		$document->read($rtf);
		
		$expected = $rtf;
		$actual   = $document->write();
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
	
	/**
	 * write() should return a string if the format is text
	 */
	public function testWrite_returnsString_ifFormatIsText()
	{
		$rtf = '{\b foo\b0}';
		
		$document = new Document();
		$document->read($rtf);
		
		$expected = 'foo';
		$actual   = $document->write('text');
		
		$this->assertEquals($expected, $actual);
		
		return;
	}
}
