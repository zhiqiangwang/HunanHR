<?php
namespace HR\PositionBundle\Twig\Extension;

mb_internal_encoding('UTF-8');

class StringExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'substring'       => new \Twig_Filter_Method($this, 'substring'),
            'obfuscate_email' => new \Twig_Filter_Method($this, 'obfuscateEmail')
        );
    }

    public function substring($input, $length)
    {
        if (false !== mb_stripos($input, '[tag]')) {
            return self::tagSubstring($input, $length);
        }

        $len       = mb_strlen($input);
        $substring = mb_substr($input, 0, $length);

        if ($len > $length) {
            $substring .= '...';
        }

        return $substring;
    }


    public function obfuscateEmail($email)
    {
        if (false !== $pos = strpos($email, '@')) {
            $email = '...' . substr($email, $pos);
        }

        return $email;
    }

    public function getName()
    {
        return 'markup_extension.substring';
    }

    private static function tagSubstring($input, $length)
    {
        $splitLines = preg_split('/(\[tag\]|\[\/tag\])/u', $input, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        $inTag    = false;
        $position = 0;
        $tagLen   = 0;
        foreach ($splitLines as $line) {
            if ($line == '[tag]' || $line == '[/tag]') {
                if ($line == '[tag]') {
                    $inTag = true;
                }

                if ($line == '[/tag]') {
                    $inTag = false;
                }

                $tagLen += strlen($line);
                continue;
            }

            $position += mb_strlen($line);

            if ($position >= $length) {
                $position -= ($position - $length);
                break;
            }
        }

        $substring = mb_substr($input, 0, $position + $tagLen);

        if ($inTag) {
            $substring .= '[/tag]';
        }

        if ($position >= $length) {
            $substring .= '...';
        }

        return $substring;
    }
}