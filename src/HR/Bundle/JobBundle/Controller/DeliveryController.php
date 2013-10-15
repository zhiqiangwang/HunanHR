<?php
namespace HR\Bundle\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class DeliveryController extends Controller
{
    /**
     * @Template()
     */
    public function newAction(Request $request, $jobId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $jobManager      = $this->getJobManager();
        $deliveryManager = $this->getDeliveryManager();
        $job             = $jobManager->findJobById($jobId);

        if (null == $job) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')
            ->add($job->getTitle(), $this->generateUrl('job_show', array('jobId' => $job->getId())))
            ->add('发送简历');

        $delivery = $deliveryManager->findDeliveryBySenderAndJob($user, $job);

        if (null !== $delivery) {
            $this->get('session')->getFlashBag()->add('success', '该职位已发送过简历');

            return $this->redirect($this->generateUrl('job_show', array('jobId' => $jobId)));
        }

        $delivery = $deliveryManager->createDelivery($user, $job);
        $delivery->setTitle(sprintf('%s 应聘 %s 职位', $user->getScreenName(), $job->getTitle()));
        $delivery->setBody(sprintf('你好，以下是湖南英才网用户 %s 的简历，敬请查阅。谢谢。', $user->getScreenName()));

        $form = $this->getForm();
        $form->setData($delivery);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $deliveryManager->updateDelivery($delivery);
            $this->get('session')->getFlashBag()->add('success', '简历已发送');

            return $this->redirect($this->generateUrl('job_show', array('jobId' => $jobId)));
        }

        return array(
            'job'  => $job,
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function sentAction()
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')
            ->add('发出的简历');

        $pager = $this->getDeliveryManager()->findDeliveriesBySender($user, $this->getRequest()->get('page'));

        return array(
            'pager' => $pager
        );
    }

    /**
     * @Template()
     */
    public function receivedAction()
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')
            ->add('收到的简历');

        $pager = $this->getDeliveryManager()->findDeliveriesByReceiver($user, $this->getRequest()->get('page'));

        return array(
            'pager' => $pager
        );
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getForm()
    {
        return $this->get('delivery.form');
    }

    /**
     * @return \HR\Bundle\JobBundle\EntityManager\DeliveryManager
     */
    private function getDeliveryManager()
    {
        return $this->get('delivery.manager');
    }

    /**
     * @return \HR\Bundle\JobBundle\EntityManager\JobManager
     */
    private function getJobManager()
    {
        return $this->get('job.manager.default');
    }
}