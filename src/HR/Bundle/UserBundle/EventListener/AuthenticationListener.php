<?php
namespace HR\Bundle\UserBundle\EventListener;

use HR\Bundle\UserBundle\Event\FilterUserResponseEvent;
use HR\Bundle\UserBundle\Event\UserEvent;
use HR\Bundle\UserBundle\Security\LoginManagerInterface;
use HR\Bundle\UserBundle\UserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class AuthenticationListener implements EventSubscriberInterface
{
    private $loginManager;
    private $firewallName;

    public function __construct(LoginManagerInterface $loginManager, $firewallName)
    {
        $this->loginManager = $loginManager;
        $this->firewallName = $firewallName;
    }

    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::REGISTRATION_COMPLETED    => 'authenticate',
            UserEvents::RESETTING_RESET_COMPLETED => 'authenticate'
        );
    }

    public function authenticate(FilterUserResponseEvent $event)
    {
        if (!$event->getUser()->isEnabled()) {
            return;
        }

        try {
            $this->loginManager->loginUser($this->firewallName, $event->getUser(), $event->getResponse());

            $event->getDispatcher()->dispatch(UserEvents::SECURITY_IMPLICIT_LOGIN, new UserEvent($event->getUser(), $event->getRequest()));
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }
}