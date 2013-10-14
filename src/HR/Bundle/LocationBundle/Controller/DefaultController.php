<?php

namespace HR\Bundle\LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HRLocationBundle:Default:index.html.twig', array('name' => $name));
    }
}
