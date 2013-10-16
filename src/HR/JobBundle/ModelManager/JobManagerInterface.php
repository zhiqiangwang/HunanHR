<?php
namespace HR\JobBundle\ModelManager;

use HR\JobBundle\Model\JobInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface JobManagerInterface
{
    public function createJob(UserInterface $user);

    public function findJobsPagerByUser(UserInterface $user, $page = 1);

    public function findJobsPagerByLatest($page = 1);

    public function findJobById($id);

    public function findAllJobs();

    public function updateJob(JobInterface $job);

    public function softDeleteJob(JobInterface $job);

    public function isNewJob(JobInterface $job);

    public function getClass();
}