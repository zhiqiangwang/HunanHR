<?php
namespace HR\JobBundle\Acl;
use HR\JobBundle\Model\JobInterface;
use HR\JobBundle\ModelManager\JobManagerInterface;
use HR\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class AclJobManager implements JobManagerInterface
{
    /**
     * @var JobManagerInterface
     */
    protected $realManager;

    /**
     * @var JobAclInterface
     */
    protected $jobAcl;

    /**
     * @param JobManagerInterface $realManager
     * @param JobAclInterface     $acl
     */
    public function __construct(JobManagerInterface $realManager, JobAclInterface $acl)
    {
        $this->realManager = $realManager;
        $this->jobAcl      = $acl;
    }

    /**
     * {@inheritDoc}
     */
    public function createJob(UserInterface $user)
    {
        return $this->realManager->createJob($user);
    }

    /**
     * {@inheritDoc}
     */
    public function findJobById($id)
    {
        return $this->realManager->findJobById($id);
    }

    public function findAllJobs()
    {
        return $this->realManager->findAllJobs();
    }

    /**
     * {@inheritDoc}
     */
    public function findJobsPagerByUser(UserInterface $user, $page = 1)
    {
        return $this->realManager->findJobsPagerByUser($user, $page);
    }

    /**
     * {@inheritDoc}
     */
    public function findJobsPagerByLatest($page = 1)
    {
        return $this->realManager->findJobsPagerByUser($page);
    }

    /**
     * {@inheritDoc}
     */
    public function updateJob(JobInterface $job)
    {
        if (!$this->jobAcl->canCreate()) {
            throw new AccessDeniedException();
        }

        $newJob = $this->isNewJob($job);

        if (!$newJob && !$this->jobAcl->canEdit($job)) {
            throw new AccessDeniedException();
        }

        $this->realManager->updateJob($job);

        if ($newJob) {
            $this->jobAcl->setDefaultAcl($job);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function deleteJob(JobInterface $job)
    {
        if (!$this->jobAcl->canDelete($job)) {
            throw new AccessDeniedException();
        }

        $this->realManager->deleteJob($job);
    }

    /**
     * {@inheritDoc}
     */
    public function isNewJob(JobInterface $job)
    {
        return $this->realManager->isNewJob($job);
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->realManager->getClass();
    }
}