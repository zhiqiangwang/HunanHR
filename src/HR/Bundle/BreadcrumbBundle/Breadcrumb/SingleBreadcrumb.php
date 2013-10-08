<?php
namespace HR\Bundle\BreadcrumbBundle\Breadcrumb;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class SingleBreadcrumb
{
    public $text;
    public $url;

    public function __construct($text, $url = '')
    {
        $this->text = $text;
        $this->url  = $url;
    }
}