<?php
namespace HR\PositionBundle\EventListener;
use HR\PositionBundle\Event\PositionEvent;
use HR\PositionBundle\PositionEvents;
use HR\UserBundle\ModelManager\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PositionCountersListener implements EventSubscriberInterface
{
    private $userManager;

    function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function onPositionSaveCompleted(PositionEvent $event)
    {
        $position = $event->getPosition();

        $user = $position->getUser();
        $user->incrementNumPositions(1);

        $this->userManager->updateUser($user);
    }

    public function onPositionDeleteCompleted(PositionEvent $event)
    {
        $position = $event->getPosition();

        $user = $position->getUser();
        $user->subtractNumPositions(1);

        $this->userManager->updateUser($user);
    }

    public static function getSubscribedEvents()
    {
        return array(
            PositionEvents::POSITION_SAVE_COMPLETED   => 'onPositionSaveCompleted',
            PositionEvents::POSITION_DELETE_COMPLETED => 'onPositionDeleteCompleted'
        );
    }

}