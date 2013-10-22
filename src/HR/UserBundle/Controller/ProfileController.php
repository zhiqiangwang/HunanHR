<?php
namespace HR\UserBundle\Controller;

use HR\UserBundle\Event\FilterUserResponseEvent;
use HR\UserBundle\Event\UserEvent;
use HR\UserBundle\UserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ProfileController extends Controller
{
    public function editAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $oldUser = clone $user;

        $this->get('breadcrumb')->add('基本资料');

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('user.form.profile');
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($oldUser->getEmail() !== $user->getEmail()) {
                $dispatcher->dispatch(UserEvents::EMAIL_CHANGE_COMPLETED, new UserEvent($user, $request));

                $this->get('session')->getFlashBag()->add('success', sprintf('验证邮件已发送至%s', $user->getEmail()));
            }

            $this->getUserManager()->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', '基本资料已更新');

            if (null !== $from = $request->get('from')) {
                $response = $this->redirect($from);
            } else {
                $response = $this->redirect($this->generateUrl('profile_edit'));
            }

            $dispatcher->dispatch(UserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('HRUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function showAction($username)
    {
        $user = $this->getUserManager()->findUserByUsername($username);

        if (null == $user) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')
            ->add($user->getScreenName(), $this->generateUrl('profile_show', array('username' => $username)));

        $pager = $this->getPositionManager()->findPositionsPagerByUser($user);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        return $this->render('HRUserBundle:Profile:show.html.twig', array(
            'user'  => $user,
            'pager' => $pager,
        ));
    }

    public function positionsAction(Request $request, $username)
    {
        $user = $this->getUserManager()->findUserByUsername($username);

        if (null == $user) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')
            ->add($user->getScreenName(), $this->generateUrl('profile_show', array('username' => $username)))
            ->add('全部职位');

        $pager = $this->getPositionManager()->findPositionsPagerByUser($user, $request->get('page', 1));

        return $this->render('HRUserBundle:Profile:positions.html.twig', array(
            'user'  => $user,
            'pager' => $pager,
        ));
    }

    public function resendConfirmEmailAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        if ($user->isEmailConfirmed()) {
            return $this->redirect($this->generateUrl('home'));
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $this->get('session')->getFlashBag()->add('success', '确认邮件已发送');

        $response = $this->redirect($this->generateUrl('home'));

        $dispatcher->dispatch(UserEvents::REGISTRATION_SUCCESS, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * @return \HR\UserBundle\EntityManager\UserManager
     */
    private function getUserManager()
    {
        return $this->get('user.user_manager');
    }

    /**
     * @return \HR\PositionBundle\EntityManager\PositionManager
     */
    private function getPositionManager()
    {
        return $this->get('position.manager.default');
    }
}