<?php
namespace HR\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ResumeController extends Controller
{
    public function showAction()
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('简历预览');

        return $this->render('HRUserBundle:Resume:show.html.twig', array(
            'user' => $user
        ));
    }
}