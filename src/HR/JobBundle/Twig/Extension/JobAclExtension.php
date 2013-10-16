<?php
namespace HR\JobBundle\Twig\Extension;
use HR\JobBundle\Acl\JobAclInterface;
use HR\JobBundle\Model\JobInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class JobAclExtension extends \Twig_Extension
{
    /**
     * @var JobAclInterface
     */
    protected $jobAcl;

    /**
     * @param JobAclInterface $jobAcl
     */
    public function __construct(JobAclInterface $jobAcl)
    {
        $this->jobAcl = $jobAcl;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'can_create_job' => new \Twig_Function_Method($this, 'canCreate'),
            'can_view_job'   => new \Twig_Function_Method($this, 'canView'),
            'can_edit_job'   => new \Twig_Function_Method($this, 'canEdit'),
            'can_delete_job' => new \Twig_Function_Method($this, 'canDelete'),
        );
    }

    /**
     * @return boolean
     */
    public function canCreate()
    {
        return $this->jobAcl->canCreate();
    }

    /**
     * @param JobInterface $job
     *
     * @return boolean
     */
    public function canView(JobInterface $job)
    {
        return $this->jobAcl->canView($job);
    }

    /**
     * @param JobInterface $job
     *
     * @return boolean
     */
    public function canEdit(JobInterface $job)
    {
        return $this->jobAcl->canEdit($job);
    }

    /**
     * @param JobInterface $job
     *
     * @return boolean
     */
    public function canDelete(JobInterface $job)
    {
        return $this->jobAcl->canDelete($job);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ghost.job_acl';
    }
}