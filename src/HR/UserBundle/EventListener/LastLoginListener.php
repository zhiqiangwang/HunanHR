<?php
namespace HR\UserBundle\EventListener;

use HR\UserBundle\Event\UserEvent;
use HR\UserBundle\Model\UserInterface;
use HR\UserBundle\ModelManager\UserManagerInterface;
use HR\UserBundle\UserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class LastLoginListener implements EventSubscriberInterface
{
    protected $userManager;
    protected $request;

    public function __construct(UserManagerInterface $userManager, Request $request)
    {
        $this->userManager = $userManager;
        $this->request     = $request;
    }

    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::SECURITY_IMPLICIT_LOGIN => 'onImplicitLogin',
            SecurityEvents::INTERACTIVE_LOGIN   => 'onSecurityInteractiveLogin',
        );
    }

    public function onImplicitLogin(UserEvent $event)
    {
        $user = $event->getUser();

        $user->setLastLogin(new \DateTime());
        $user->setLastLoginIp($this->request->getClientIp());
        $this->userManager->updateUser($user);
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof UserInterface) {
            $user->setLastLogin(new \DateTime());
            $user->setLastLoginIp($this->request->getClientIp());
            $this->userManager->updateUser($user);
        }
    }
}