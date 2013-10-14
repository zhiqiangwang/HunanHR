<?php
namespace HR\Bundle\JobBundle\Controller;

use HR\Bundle\JobBundle\Event\JobEvent;
use HR\Bundle\JobBundle\JobEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

            $this->getDispatcher()->dispatch(JobEvents::JOB_SAVE_COMPLETED, new JobEvent($job));

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

            $this->getDispatcher()->dispatch(JobEvents::JOB_EDIT_COMPLETED, new JobEvent($job));

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

        $this->getDispatcher()->dispatch(JobEvents::JOB_DELETE_COMPLETED, new JobEvent($job));

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

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private function getDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }
}
