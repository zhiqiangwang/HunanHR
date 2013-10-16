<?php
namespace HR\JobBundle\Acl;
use HR\JobBundle\Model\JobInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface JobAclInterface
{
    public function canCreate();

    public function canView(JobInterface $job);

    public function canEdit(JobInterface $job);

    public function canDelete(JobInterface $job);

    public function setDefaultAcl(JobInterface $topic);

    public function installFallbackAcl();

    public function uninstallFallBackAcl();
}