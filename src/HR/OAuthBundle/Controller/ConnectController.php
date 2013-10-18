<?php
namespace HR\OAuthBundle\Controller;

use Detection\MobileDetect;
use HR\UserBundle\Event\FilterUserResponseEvent;
use HR\UserBundle\Event\UserEvent;
use HR\UserBundle\UserEvents;
use HWI\Bundle\OAuthBundle\Controller\ConnectController as BaseConnectController;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ConnectController extends BaseConnectController
{
    public function connectServiceAction(Request $request, $service)
    {
        return new RedirectResponse($this->generate('home'));
    }

    /**
     * Redirect to auth
     */
    public function redirectToServiceAction(Request $request, $service)
    {
        $param = $this->container->getParameter('hwi_oauth.target_path_parameter');

        $mobileDetect = new MobileDetect();
        $display      = $mobileDetect->isMobile() ? 'mobile' : 'default';

        if (!empty($param) && $request->hasSession() && $targetUrl = $request->get($param, null, true)) {
            $providerKey = $this->container->getParameter('hwi_oauth.firewall_name');
            $request->getSession()->set('_security.' . $providerKey . '.target_path', $targetUrl);
        }

        return new RedirectResponse($this->container->get('hwi_oauth.security.oauth_utils')->getAuthorizationUrl($request, $service, null, array('display' => $display)));
    }

    /**
     * Check token
     */
    public function checkAction(Request $request)
    {
        $hasUser = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED');
        $connect = $this->container->getParameter('hwi_oauth.connect');

        $error = $this->getErrorForRequest($request);

        if ($connect
            && !$hasUser
            && $error instanceof AccountNotLinkedException
        ) {
            $session = $request->getSession();
            $session->set('_hwi_oauth.registration_error', $error);
            $uri = $this->generate('oauth_connect_wizard');

            return new RedirectResponse($uri);
        }

        if ($error instanceof AuthenticationException) {
            $this->container->get('session')->getFlashBag()->add('error', '很抱歉，服务暂不可用，请稍后重试');
        }

        return new RedirectResponse($this->generate('login'));
    }

    /**
     * With OAuth registration
     *
     * @Template()
     */
    public function registrationAction(Request $request, $key = null)
    {
        $this->container->get('breadcrumb')->add('完成注册');

        $connect = $this->container->getParameter('hwi_oauth.connect');
        if (!$connect) {
            throw new NotFoundHttpException();
        }

        // if user logged
        $hasUser = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if ($hasUser) {
            return new RedirectResponse($this->generate('profile_edit'));
        }

        $session = $request->getSession();
        $error   = $session->get('_hwi_oauth.registration_error');

        if (!$error instanceof AccountNotLinkedException) {
            return new RedirectResponse($this->generate('login'));
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
        $user->setUsername($userInformation->getDomain());
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
            $this->container->get('session')->getFlashBag()->add('success', '注册完成，请完善您的资料。');

            $response = new RedirectResponse($this->generate('profile_edit'));

            $dispatcher->dispatch(UserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return array(
            'form'            => $form->createView(),
            'userInformation' => $userInformation
        );
    }

    /**
     * @return \HR\UserBundle\EntityManager\UserManager
     */
    private function getUserManager()
    {
        return $this->container->get('user.user_manager');
    }
}