<?php
namespace HR\Bundle\UserBundle\Controller;

use HR\Bundle\UserBundle\Event\FilterUserResponseEvent;
use HR\Bundle\UserBundle\Event\UserEvent;
use HR\Bundle\UserBundle\UserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RegistrationController extends Controller
{
    /**
     * @Template()
     */
    public function registerAction(Request $request)
    {
        if (null != $this->getUser()) {
            return $this->redirect($this->generateUrl('profile_edit'));
        }

        $this->get('breadcrumb')->add('注册');

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('user.form.registration');

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $this->getUserManager()->createUser();

        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $dispatcher->dispatch(UserEvents::REGISTRATION_SUCCESS, new UserEvent($user, $request));

            $this->getUserManager()->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', '注册完成，请完善您的资料。');

            $response = $this->redirect($this->generateUrl('profile_edit'));

            $dispatcher->dispatch(UserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return array(
            'form' => $form->createView()
        );
    }

    public function confirmAction(Request $request, $token)
    {
        $user = $this->getUserManager()->findUserByConfirmationToken($token);

        if (null === $user) {
            throw $this->createNotFoundException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEmailConfirmed(true);

        $this->getUserManager()->updateUser($user);

        $response = $this->redirect($this->generateUrl('login'));

        $dispatcher->dispatch(UserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        $this->get('session')->getFlashBag()->add('success', '您的电子邮件地址已确认');

        return $response;
    }

    /**
     * @return \HR\Bundle\UserBundle\EntityManager\UserManager
     */
    private function getUserManager()
    {
        return $this->get('user.user_manager');
    }
}