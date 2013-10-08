<?php
namespace HR\Bundle\BreadcrumbBundle\Twig\Extension;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class BreadcrumbExtension extends \Twig_Extension
{
    protected $container;

    protected $breadcrumb;

    public function __construct(ContainerInterface $container)
    {
        $this->container  = $container;
        $this->breadcrumb = $container->get('breadcrumb');
    }

    public function getFunctions()
    {
        return array(
            'breadcrumbs'        => new \Twig_Function_Method($this, 'getBreadcrumbs', array("is_safe" => array("html"))),
            'render_breadcrumbs' => new \Twig_Function_Method($this, 'renderBreadcrumbs', array("is_safe" => array("html"))),
            'page_title'         => new \Twig_Function_Method($this, 'pageTitle', array("is_safe" => array("html")))
        );
    }

    public function pageTitle()
    {
        $breadcrumbs = $this->getBreadcrumbs();

        if (count($breadcrumbs) > 1) {
            return end($breadcrumbs)->text;
        }

        return null;
    }

    public function getBreadcrumbs()
    {
        return $this->breadcrumb->getBreadCrumbs();
    }

    public function renderBreadcrumbs()
    {
        return $this->container->get('templating')->render('HRBreadcrumbBundle:Breadcrumb:breadcrumb.html.twig', array(
            'breadcrumbs' => $this->getBreadcrumbs()
        ));
    }

    public function getName()
    {
        return 'breadcrumb_extension';
    }
}