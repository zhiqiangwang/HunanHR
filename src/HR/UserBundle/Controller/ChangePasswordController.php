<?php
namespace HR\UserBundle\Controller;

use HR\UserBundle\Event\FilterUserResponseEvent;
use HR\UserBundle\UserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ChangePasswordController extends Controller
{
    public function editAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('基本资料', $this->generateUrl('profile_edit'))->add('修改密码');

        /** @var \HR\UserBundle\EntityManager\UserManager $userManager */
        $userManager = $this->get('user.user_manager');

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('user.form.change_password');

        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', '密码已更新');

            $response = $this->redirect($this->generateUrl('change_password'));

            $dispatcher->dispatch(UserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('HRUserBundle:ChangePassword:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}