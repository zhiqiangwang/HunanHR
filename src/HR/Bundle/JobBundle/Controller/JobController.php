<?php
namespace HR\Bundle\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class JobController extends Controller
{
    /**
     * @Template()
     */
    public function newAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('发布职位');

        $job = $this->getJobManager()->createJob($user);
        $job->setCompanyName($user->getCompanyName());
        $job->setContactEmail($user->getEmail());

        $form = $this->getForm();
        $form->setData($job);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getJobManager()->updateJob($job);

            return $this->redirect($this->generateUrl('job_show', array('jobId' => $job->getId())));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function showAction($jobId)
    {
        $job = $this->getJobManager()->findJobById($jobId);

        if (!$job) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')->add($job->getTitle());

        return array(
            'job' => $job
        );
    }

    /**
     * @Template()
     */
    public function editAction(Request $request, $jobId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $job = $this->getJobManager()->findJobById($jobId);

        if (null == $job) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')
            ->add($job->getTitle(), $this->generateUrl('job_show', array('jobId' => $job->getId())))
            ->add('编辑');

        if (!$this->get('job.acl')->canEdit($job)) {
            throw new AccessDeniedException();
        }

        $form = $this->getForm();
        $form->setData($job);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getJobManager()->updateJob($job);

            return $this->redirect($this->generateUrl('job_show', array('jobId' => $job->getId())));
        }

        return array(
            'form' => $form->createView(),
            'job'  => $job
        );
    }

    /**
     * @Template()
     */
    public function deleteAction($jobId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $job = $this->getJobManager()->findJobById($jobId);

        if (null == $job) {
            throw $this->createNotFoundException();
        }

        if (!$this->get('job.acl')->canDelete($job)) {
            throw new AccessDeniedException();
        }

        $this->getJobManager()->deleteJob($job);

        $this->get('session')->getFlashBag()->add('success', '职位已删除');

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @return \HR\Bundle\JobBundle\EntityManager\JobManager $jobManager
     */
    private function getJobManager()
    {
        return $this->get('job.manager.acl');
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getForm()
    {
        return $this->get('job.form');
    }
}
