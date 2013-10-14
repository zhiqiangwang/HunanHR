<?php
namespace HR\Bundle\JobBundle\ModelManager;

use HR\Bundle\JobBundle\Model\JobInterface;
use HR\Bundle\UserBundle\Model\UserInterface;

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

    public function deleteJob(JobInterface $job);

    public function isNewJob(JobInterface $job);

    public function getClass();
}