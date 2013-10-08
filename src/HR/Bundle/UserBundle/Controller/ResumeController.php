<?php
namespace HR\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ResumeController extends Controller
{
    /**
     * @Template()
     */
    public function editAction()
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        return array(
            'user' => $user
        );
    }
}