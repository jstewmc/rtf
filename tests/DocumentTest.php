<?php

namespace Jstewmc\Rtf;

use org\bovigo\vfs\{vfsStream, vfsStreamDirectory, vfsStreamFile};

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    private vfsStreamDirectory $root;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('root');
    }

    public function testGetRootReturnsRoot(): void
    {
        $this->assertEquals(new Element\Group(), (new Document(''))->getRoot());
    }

    public function testConstructReadsStringWhenSourceIsText(): void
    {
        $this->assertSuccess('{\b foo\b0}');
    }

    public function testConstructLoadsFileWhenSourceIsFile(): void
    {
        $this->assertSuccess($this->file('{\b foo\b0}')->url());
    }

    public function testToStringReturnsStringWhenElementsDoNotExist(): void
    {
        $this->assertEquals('{}', (string)(new Document('')));
    }

    public function testToStringReturnsStringWhenElementDoExist(): void
    {
        $rtf = '{\b foo\b0}';

        $this->assertEquals($rtf, (string)(new Document($rtf)));
    }

    public function testWriteThrowsInvalidArgumentExceptionWhenFormatIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Document(''))->write('foo');
    }

    public function testWriteReturnsStringWhenFormatIsHtml(): void
    {
        $this->assertEquals(
            '<section style=""><p style=""><span style="font-weight: bold;">'
                . 'foo</span></p></section>',
            (new Document('{\b foo\b0}'))->write('html')
        );
    }

    public function testWriteReturnsStringWhenFormatIsRtf(): void
    {
        $this->assertEquals('{\b foo\b0}', (new Document('{\b foo\b0}'))->write());
    }

    public function testWriteReturnsStringWhenFormatIsText(): void
    {
        $this->assertEquals('foo', (new Document('{\b foo\b0}'))->write('text'));
    }

    public function testWriteReturnsStringWhenEncodingIsDeclared(): void
    {
        // A nowdoc is easier than juggling the backslash and quotation marks.
        $rtf = <<<'RTF'
            {\rtf1\mac \'80}
            RTF;

        $this->assertEquals('Ä', (new Document($rtf))->write('text'));
    }

    public function testSaveThrowsInvalidArgumentExceptionWhenFormatIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Document(''))->save("{$this->root->url()}/example.txt", 'foo');
    }

    public function testSaveThrowsInvalidArgumentExceptionWhenExtensionIsNotDetectable(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Document(''))->save('foo');
    }

    public function testSaveWritesToFile(): void
    {
        $file = vfsStream::newFile('example.rtf')->at($this->root);

        $rtf = '{\b foo\b0}';

        (new Document($rtf))->save($file->url());

        $this->assertStringMatchesFormatFile($file->url(), $rtf);
    }

    private function file(string $content): vfsStreamFile
    {
        return vfsStream::newFile('example.txt')
            ->withContent($content)
            ->at($this->root);
    }

    private function assertSuccess(string $source): void
    {
        $this->assertEquals(
            3,
            (new Document($source))->getRoot()->getLength()
        );
    }
}
