<?php
namespace HR\OAuthBundle\Controller;

use Detection\MobileDetect;
use HR\UserBundle\Event\FilterUserResponseEvent;
use HR\UserBundle\Event\UserEvent;
use HR\UserBundle\UserEvents;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ConnectController extends Controller
{
    /**
     * Auth
     */
    public function connectServiceAction(Request $request, $service)
    {
        $session = $request->getSession();

        $connect = $this->container->getParameter('hwi_oauth.connect');
        if (!$connect) {
            throw $this->createNotFoundException();
        }

        if (!$user = $this->getUser()) {
            throw new AccessDeniedException('Cannot connect an account.');
        }

        // Get the data from the resource owner
        $resourceOwner = $this->getResourceOwnerByName($service);

        if ($resourceOwner->handles($request)) {
            $accessToken = $resourceOwner->getAccessToken(
                $request,
                $this->generateUrl('hwi_oauth_connect_service', array('service' => $service), true)
            );

            // save in session
            $session->set('oauth.connect_access', $accessToken);
        } else {
            $accessToken = $session->get('oauth.connect_access');
        }

        $userInformation = $resourceOwner->getUserInformation($accessToken);

        $this->container->get('hwi_oauth.account.connector')->connect($user, $userInformation);

        $this->setFlash('绑定成功');

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * Redirect to auth
     */
    public function redirectToServiceAction(Request $request, $service)
    {
        $param        = $this->container->getParameter('hwi_oauth.target_path_parameter');
        $mobileDetect = new MobileDetect();
        $display      = $mobileDetect->isMobile() ? 'mobile' : 'default';

        if (!empty($param) && $request->hasSession() && $targetUrl = $request->get($param, null, true)) {
            $providerKey = $this->container->getParameter('hwi_oauth.firewall_name');
            $request->getSession()->set('_security.' . $providerKey . '.target_path', $targetUrl);
        }

        return $this->redirect($this->container->get('hwi_oauth.security.oauth_utils')->getAuthorizationUrl($request, $service, null, array('display' => $display)));
    }

    /**
     * Check token
     */
    public function checkAction(Request $request)
    {
        $user    = $this->getUser();
        $error   = $this->getErrorForRequest($request);
        $connect = $this->container->getParameter('hwi_oauth.connect');

        if ($connect
            && !$user
            && $error instanceof AccountNotLinkedException
        ) {
            $session = $request->getSession();
            $session->set('_hwi_oauth.registration_error', $error);

            return $this->redirect($this->generateUrl('oauth_connect_wizard'));
        }

        if ($error instanceof AuthenticationException) {
            $this->setFlash('很抱歉，服务暂不可用，请稍后重试', 'error');
        }

        return $this->redirect($this->generateUrl('login'));
    }

    /**
     * With OAuth registration
     */
    public function registrationAction(Request $request, $key = null)
    {
        $this->container->get('breadcrumb')->add('完成注册');

        $connect = $this->container->getParameter('hwi_oauth.connect');
        if (!$connect) {
            throw $this->createNotFoundException();
        }

        // if user logged
        if ($this->getUser()) {
            return $this->redirect($this->generateUrl('home'));
        }

        $session = $request->getSession();
        $error   = $session->get('_hwi_oauth.registration_error');

        if (!$error instanceof AccountNotLinkedException) {
            return $this->redirect($this->generateUrl('login'));
        }

        /** @var \HR\OAuthBundle\OAuth\Response\WeiboUserResponse $userInformation */
        $userInformation = $this
            ->getResourceOwnerByName($error->getResourceOwnerName())
            ->getUserInformation($error->getRawToken());

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->container->get('user.form.registration');

        /** @var \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher */
        $dispatcher = $this->container->get('event_dispatcher');

        /** @var \HR\UserBundle\Model\UserInterface $user */
        $user = $this->getUserManager()->createUser();

        // Defaults value
        $user->setScreenName($userInformation->getNickname());
        $user->setGender($userInformation->getGender());
        $user->setUsername($userInformation->getScreenName());
        $user->setAvatarBigUrl($userInformation->getAvatarBigUrl());
        $user->setAvatarSmallUrl($userInformation->getAvatarSmallUrl());
        $user->setBio($userInformation->getBio());
        $user->setHomepage($userInformation->getHomepage());

        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $session->remove('_hwi_oauth.registration_error');

            $dispatcher->dispatch(UserEvents::REGISTRATION_SUCCESS, new UserEvent($user, $request));

            $this->container->get('hwi_oauth.account.connector')->connect($user, $userInformation);
            $this->setFlash('注册完成，请完善您的资料。');

            $response = $this->redirect($this->generateUrl('profile_edit'));

            $dispatcher->dispatch(UserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('HROAuthBundle:Connect:registration.html.twig', array(
            'form'            => $form->createView(),
            'userInformation' => $userInformation
        ));
    }

    /**
     * Set flash message
     *
     * @param string $message
     * @param string $level
     */
    protected function setFlash($message, $level = 'success')
    {
        $this->container->get('session')->getFlashBag()->add($level, $message);
    }

    /**
     * @return \HR\UserBundle\EntityManager\UserManager
     */
    protected function getUserManager()
    {
        return $this->container->get('user.user_manager');
    }

    /**
     * Get the security error for a given request.
     *
     * @param Request $request
     *
     * @return string|\Exception
     */
    protected function getErrorForRequest(Request $request)
    {
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        return $error;
    }

    /**
     * Get a resource owner by name.
     *
     * @param string $name
     *
     * @return ResourceOwnerInterface
     *
     * @throws \RuntimeException if there is no resource owner with the given name.
     */
    protected function getResourceOwnerByName($name)
    {
        $ownerMap = $this->container->get('hwi_oauth.resource_ownermap.' . $this->container->getParameter('hwi_oauth.firewall_name'));

        if (null === $resourceOwner = $ownerMap->getResourceOwnerByName($name)) {
            throw new \RuntimeException(sprintf("No resource owner with name '%s'.", $name));
        }

        return $resourceOwner;
    }
}