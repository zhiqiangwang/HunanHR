<?php
namespace HR\Bundle\JobBundle\EventListener;
use HR\Bundle\JobBundle\Event\JobEvent;
use HR\Bundle\JobBundle\JobEvents;
use HR\Bundle\UserBundle\ModelManager\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class JobCountersListener implements EventSubscriberInterface
{
    private $userManager;

    function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function onJobSaveCompleted(JobEvent $event)
    {
        $job = $event->getJob();

        $user = $job->getUser();
        $user->incrementNumJobs(1);

        $this->userManager->updateUser($user);
    }

    public function onJobDeleteCompleted(JobEvent $event)
    {
        $job = $event->getJob();

        $user = $job->getUser();
        $user->subtractNumJobs(1);

        $this->userManager->updateUser($user);
    }

    public static function getSubscribedEvents()
    {
        return array(
            JobEvents::JOB_SAVE_COMPLETED   => 'onJobSaveCompleted',
            JobEvents::JOB_DELETE_COMPLETED => 'onJobDeleteCompleted'
        );
    }

}