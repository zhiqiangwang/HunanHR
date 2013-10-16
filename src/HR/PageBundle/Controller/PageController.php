<?php
namespace HR\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PageController extends Controller
{
    public function aboutAction()
    {
        $this->get('breadcrumb')->add('关于');

        return $this->render('HRPageBundle:Page:about.html.twig');
    }

    public function contactAction()
    {
        $this->get('breadcrumb')->add('联系');

        return $this->render('HRPageBundle:Page:contact.html.twig');
    }
}