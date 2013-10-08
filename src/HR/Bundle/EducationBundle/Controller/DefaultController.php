<?php

namespace HR\Bundle\EducationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HREducationBundle:Default:index.html.twig', array('name' => $name));
    }
}
