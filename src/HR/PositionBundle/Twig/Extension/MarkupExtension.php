<?php
namespace HR\PositionBundle\Twig\Extension;

class MarkupExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'markup'    => new \Twig_Filter_Method($this, 'markup', array('pre_escape' => 'html', 'is_safe' => array('html'))),
            'highlight' => new \Twig_Filter_Method($this, 'highlight', array('pre_escape' => 'html', 'is_safe' => array('html'))),
            'location'  => new \Twig_Filter_Method($this, 'location'),
        );
    }

    public function highlight($input)
    {
        return preg_replace('/\[tag\](.+?)\[\/tag\]/su', '<span class="highlighting">$1</span>', $input);
    }

    public function markup($input)
    {
        $input = preg_replace('/\n?(.+?)(?:\n\s*|\z){2,}/su', '<p>$1</p>', $input);
        $input = nl2br($input);
        $input = str_replace('　', '', $input);

        return $input;
    }

    public function location($input)
    {
        $input = preg_replace('/湖南省?/u', '', $input);
        $input = str_replace('[tag][/tag]', '', $input);

        return $input;
    }

    public function getName()
    {
        return 'markup_extension.markup';
    }
}