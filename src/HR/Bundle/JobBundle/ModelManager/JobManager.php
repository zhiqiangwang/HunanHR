<?php
namespace HR\Bundle\JobBundle\ModelManager;
use HR\Bundle\JobBundle\Model\JobInterface;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class JobManager implements JobManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createJob(UserInterface $user)
    {
        $class = $this->getClass();

        /** @var JobInterface $job */
        $job = new $class();
        $job->setUser($user);

        return $job;
    }

    /**
     * {@inheritdoc}
     */
    public function updateJob(JobInterface $job)
    {
        if (null === $job->getUser()) {
            throw new \InvalidArgumentException('The position must have a user');
        }

        $this->doUpdateEducation($job);
    }

    protected abstract function doUpdateEducation($job);
}