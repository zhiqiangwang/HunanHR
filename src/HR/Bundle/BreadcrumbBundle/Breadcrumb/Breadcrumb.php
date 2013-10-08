<?php
namespace HR\Bundle\BreadcrumbBundle\Breadcrumb;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class Breadcrumb
{
    protected $breadcrumbs = array();

    public function __construct()
    {
        $this->breadcrumbs[] = new SingleBreadcrumb('湖南英才网', '/');
    }

    public function add($text, $url = '')
    {
        $this->breadcrumbs[] = new SingleBreadcrumb($text, $url);

        return $this;
    }

    public function rest()
    {
        $this->breadcrumbs = array();

        return $this;
    }

    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }
}