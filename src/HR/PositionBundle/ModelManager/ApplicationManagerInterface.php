<?php
namespace HR\PositionBundle\ModelManager;

use HR\PositionBundle\Model\ApplicationInterface;
use HR\PositionBundle\Model\PositionInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface ApplicationManagerInterface
{
    /**
     * @param UserInterface     $sender
     * @param PositionInterface $position
     *
     * @return ApplicationInterface
     */
    public function createApplication(UserInterface $sender, PositionInterface $position);

    /**
     * @param ApplicationInterface $application
     *
     * @return void
     */
    public function updateApplication(ApplicationInterface $application);

    /**
     * @param UserInterface $sender
     * @param int           $page
     *
     * @return ApplicationInterface[]
     */
    public function findApplicationsBySender(UserInterface $sender, $page = 1);

    /**
     * @param UserInterface     $sender
     * @param PositionInterface $position
     *
     * @return ApplicationInterface
     */
    public function findApplicationBySenderAndPosition(UserInterface $sender, PositionInterface $position);

    /**
     * @param UserInterface $receiver
     * @param int           $page
     *
     * @return ApplicationInterface[]
     */
    public function findApplicationsByReceiver(UserInterface $receiver, $page = 1);

    /**
     * @param int $id
     *
     * @return ApplicationInterface
     */
    public function findApplicationById($id);

    /**
     * @return string
     */
    public function getClass();
}