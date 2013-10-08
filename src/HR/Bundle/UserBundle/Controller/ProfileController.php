<?php
namespace HR\Bundle\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ProfileController extends Controller
{
    /**
     * @Template()
     */
    public function editAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('基本资料');

        /** @var \HR\Bundle\UserBundle\EntityManager\UserManager $userManager */
        $userManager = $this->get('user.manager');

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('user.form.profile');
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', '基本信息已更新');

            return $this->redirect($this->generateUrl('profile_edit'));
        }

        return array(
            'form' => $form->createView()
        );
    }
}