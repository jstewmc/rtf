<?php

namespace Jstewmc\Rtf;

class SnippetTest extends \PHPUnit\Framework\TestCase
{
	public function testConstructReturnsSnippetWhenSourceIsEmpty(): void
	{
		$this->assertEquals(0, (new Snippet(''))->getLength());
	}

	public function testConstructReturnsSnippetWhenSourceIsNotEmpty(): void
	{
		$this->assertEquals(2, (new Snippet('mis\cxds '))->getLength());
	}

	public function testWriteThrowsInvalidArgumentExceptionWhenFormatIsInvalid(): void
	{
		$this->expectException(\InvalidArgumentException::class);

		(new Snippet(''))->write('foo');
	}

	public function testWriteReturnsStringWhenFormatIsValid(): void
	{
		$this->assertEquals('\cxds ing', (new Snippet('\cxds ing'))->write());
	}
}
