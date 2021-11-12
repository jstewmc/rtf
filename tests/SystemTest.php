<?php

namespace Jstewmc\Rtf;

class SystemTest extends \PHPUnit\Framework\TestCase
{
    public function testIdempotenceWithDocument1(): void
    {
        $this->assertEquals(
            $this->document1(),
            (string)(new Document($this->document1()))
        );
    }

    private function document1(): string
    {
        return <<<'RTF'
            {\rtf1\ansi\ansicpg1252\deff0{\fonttbl{\f0\fnil Bookman Old Style;}{\f1\fnil\fcharset0 Bookman Old Style;}} \viewkind4\uc1\pard\lang1043\f0\fs20 Histoire naturelle g\f1\'e9n\'e9rale et particuli\'e8re des crustac\'e9s et des insectes. Ouvrage faisant suite aux oeuvres de Buffon, et partie du cours complet d'histoire naturelle r\'e9dig\'e9 par C. S. Sonnini, membre de plusieurs soci\'e9t\'e9s savantes. Familles naturelles des genres. Tomes 1-14. [Complete for the Arthropoda].\f0\par }
            RTF;
    }

    public function testIdempotenceWithDocument2(): void
    {
        $this->assertEquals(
            // Hmm, this is not quite idempotent :(
            str_replace("\n", '', $this->document2()),
            (string)(new Document($this->document2()))
        );
    }

    public function testTextConverstionWithDocument2(): void
    {
        $this->assertEquals(
            'This is a test',
            (new Document($this->document2()))->write('text')
        );
    }

    private function document2(): string
    {
        return <<<'RTF'
            {\rtf1\ansi\deff3\adeflang1025
            {\fonttbl{\f0\froman\fprq2\fcharset0 Times New Roman;}{\f1\froman\fprq2\fcharset2 Symbol;}{\f2\fswiss\fprq2\fcharset0 Arial;}{\f3\froman\fprq2\fcharset0 Liberation Serif{\*\falt Times New Roman};}{\f4\froman\fprq2\fcharset0 Liberation Sans{\*\falt Arial};}{\f5\fnil\fprq2\fcharset0 Lohit Devanagari;}{\f6\fnil\fprq2\fcharset0 Liberation Serif{\*\falt Times New Roman};}}
            {\colortbl;\red0\green0\blue0;\red0\green0\blue255;\red0\green255\blue255;\red0\green255\blue0;\red255\green0\blue255;\red255\green0\blue0;\red255\green255\blue0;\red255\green255\blue255;\red0\green0\blue128;\red0\green128\blue128;\red0\green128\blue0;\red128\green0\blue128;\red128\green0\blue0;\red128\green128\blue0;\red128\green128\blue128;\red192\green192\blue192;\red201\green33\blue30;}
            {\stylesheet{\s0\snext0\widctlpar\hyphpar0\cf0\kerning1\dbch\af5\langfe1081\dbch\af6\afs24\alang3082\loch\f3\fs24\lang3082 Normal;}
            {\s15\sbasedon0\snext16\widctlpar\hyphpar0\sb240\sa120\keepn\cf0\kerning1\dbch\af5\langfe1081\dbch\af6\afs24\alang3082\loch\f4\fs28 Heading;}
            {\s16\sbasedon0\snext16\sl276\slmult1\widctlpar\hyphpar0\sb0\sa140\cf0\kerning1\dbch\af5\langfe1081\dbch\af6\afs24\alang3082\loch\f3\fs24 Text Body;}
            {\s17\sbasedon16\snext17\sl276\slmult1\widctlpar\hyphpar0\sb0\sa140\cf0\kerning1\dbch\af5\langfe1081\dbch\af6\afs24\alang3082\loch\f3\fs24 List;}
            {\s18\sbasedon0\snext18\widctlpar\hyphpar0\sb120\sa120\cf0\i\kerning1\dbch\af5\langfe1081\dbch\af6\afs24\alang3082\loch\f3\fs24 Caption;}
            {\s19\sbasedon0\snext19\widctlpar\hyphpar0\cf0\kerning1\dbch\af5\langfe1081\dbch\af6\afs24\alang3082\loch\f3\fs24 Index;}
            }{\*\generator LibreOffice/6.2.2.2$Linux_X86_64 LibreOffice_project/20$Build-2}{\info{\creatim\yr2020\mo11\dy17\hr10\min43}{\revtim\yr2020\mo11\dy17\hr10\min45}{\printim\yr0\mo0\dy0\hr0\min0}}{\*\userprops}\deftab709
            \hyphauto0\viewscale90
            {\*\pgdsctbl
            {\pgdsc0\pgdscuse451\pgwsxn11906\pghsxn16838\marglsxn1134\margrsxn1134\margtsxn1134\margbsxn1134\pgdscnxt0 Default Style;}}
            \formshade{\*\pgdscno0}\paperh16838\paperw11906\margl1134\margr1134\margt1134\margb1134\sectd\sbknone\sectunlocked1\pgndec\pgwsxn11906\pghsxn16838\marglsxn1134\margrsxn1134\margtsxn1134\margbsxn1134\ftnbj\ftnstart1\ftnrstcont\ftnnar\aenddoc\aftnrstcont\aftnstart1\aftnnrlc
            {\*\ftnsep\chftnsep}\pgndec\pard\plain \s0\widctlpar\hyphpar0\cf0\kerning1\dbch\af5\langfe1081\dbch\af6\afs24\alang3082\loch\f3\fs24\lang3082{\rtlch \ltrch\loch
            This is a }{\cf17\b\rtlch \ltrch\loch
            test}
            \par }
            RTF;
    }
}
