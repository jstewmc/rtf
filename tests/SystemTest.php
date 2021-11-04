<?php

namespace Jstewmc\Rtf;

class SystemTest extends \PHPUnit\Framework\TestCase
{
    public function testDocument1(): void
    {
        $rtf = <<<RTF
            {\rtf1\ansi\ansicpg1252\deff0{\fonttbl{\f0\fnil Bookman Old Style;}{\f1\fnil\fcharset0 Bookman Old Style;}} \viewkind4\uc1\pard\lang1043\f0\fs20 Histoire naturelle g\f1\'e9n\'e9rale et particuli\'e8re des crustac\'e9s et des insectes. Ouvrage faisant suite aux oeuvres de Buffon, et partie du cours complet d'histoire naturelle r\'e9dig\'e9 par C. S. Sonnini, membre de plusieurs soci\'e9t\'e9s savantes. Familles naturelles des genres. Tomes 1-14. [Complete for the Arthropoda].\f0\par }
            RTF;

        $this->assertInstanceOf(Document::class, new Document($rtf));
    }

    public function testDocument2(): void
    {
        $rtf = <<<RTF
            {\rtf1\ansi\ansicpg1252\deff0{\fonttbl{\f0\fnil Bookman Old Style;}{\f1\fnil\fcharset0 Bookman Old Style;}} \viewkind4\uc1\pard\lang1043\f0\fs20 Histoire naturelle g\f1\'e9n\'e9rale et particuli\'e8re des crustac\'e9s et des insectes. Ouvrage faisant suite aux oeuvres de Buffon, et partie du cours complet d'histoire naturelle r\'e9dig\'e9 par C. S. Sonnini, membre de plusieurs soci\'e9t\'e9s savantes. Familles naturelles des genres. Tomes 1-14. [Complete for the Arthropoda].\f0\par }
            RTF;

        $this->assertInstanceOf(Document::class, new Document($rtf));
    }
}
