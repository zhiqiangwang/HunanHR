<?php
namespace HR\Bundle\UserBundle\EventListener;

use HR\Bundle\MailBundle\Mailer\MailerInterface;
use HR\Bundle\UserBundle\Event\UserEvent;
use HR\Bundle\UserBundle\UserEvents;
use HR\Bundle\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class EmailConfirmationListener implements EventSubscriberInterface
{
    private $mailer;
    private $tokenGenerator;

    public function __construct(MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $this->mailer         = $mailer;
        $this->tokenGenerator = $tokenGenerator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::REGISTRATION_SUCCESS   => 'onRegistrationSuccess',
            UserEvents::EMAIL_CHANGE_COMPLETED => 'onEmailChangeCompleted',
        );
    }

    public function onEmailChangeCompleted(UserEvent $event)
    {
        $user = $event->getUser();

        $user->setEmailConfirmed(false);

        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        $this->mailer->sendConfirmationEmailMessage($user);
    }

    public function onRegistrationSuccess(UserEvent $event)
    {
        $user = $event->getUser();

        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        $this->mailer->sendConfirmationEmailMessage($user);
    }
}