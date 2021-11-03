<?php

namespace Jstewmc\Rtf\Service;

use Jstewmc\Rtf\Element;

class Write
{
    private const FORMATS = ['htm', 'html', 'txt', 'text', 'rtf'];

    public function __invoke(Element\Group $root, string $format = 'rtf'): string
    {
        $format = strtolower($format);

        $this->validateFormat($format);

        if ($format === 'htm' || $format === 'html') {
            $string = $root->format('html');
            $string .= '</span></p></section>';
        } elseif ($format === 'txt' || $format === 'text') {
            $string = $root->format('text');
        } elseif ($format === 'rtf') {
            $string = $root->format('rtf');
        }

        return $string;
    }

    private function validateFormat(string $format): void
    {
        if (!in_array(strtolower($format), self::FORMATS)) {
            $formats = implode("', '", self::FORMATS);
            throw new \InvalidArgumentException(
                "format must be one of the following: '{$formats}'"
            );
        }
    }
}
