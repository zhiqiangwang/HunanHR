<?php
namespace HR\PositionBundle\ModelManager;

use HR\PositionBundle\Model\ApplicationInterface;
use HR\PositionBundle\Model\PositionInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class ApplicationManager implements ApplicationManagerInterface
{
    /**
     * @param UserInterface     $sender
     * @param PositionInterface $position
     *
     * @return ApplicationInterface
     */
    public function createApplication(UserInterface $sender, PositionInterface $position)
    {
        $class = $this->getClass();

        /** @var ApplicationInterface $application */
        $application = new $class;
        $application->setSender($sender);
        $application->setPosition($position);
        $application->setReceiver($position->getUser());

        return $application;
    }
}