<?php
namespace HR\Bundle\JobBundle\Twig\Extension;

mb_internal_encoding('UTF-8');

class StringExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'substring' => new \Twig_Filter_Method($this, 'substring', array("is_safe" => array("html"))),
        );
    }

    public function substring($input, $length)
    {
        $len       = mb_strlen($input);
        $substring = mb_substr($input, 0, $length);

        if ($len > $length) {
            $substring .= '...';
        }

        return $substring;
    }

    public function getName()
    {
        return 'markup_extension.substring';
    }
}