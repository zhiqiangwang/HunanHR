<?php
namespace HR\PositionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ApplicationController extends Controller
{
    public function newAction(Request $request, $positionId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $positionManager    = $this->getPositionManager();
        $applicationManager = $this->getApplicationManager();
        $position           = $positionManager->findPositionById($positionId);

        if (null == $position) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')
            ->add($position->getPosition(), $this->generateUrl('position_show', array('positionId' => $position->getId())))
            ->add('发送简历');

        $application = $applicationManager->findApplicationBySenderAndPosition($user, $position);

        if (null !== $application) {
            $this->get('session')->getFlashBag()->add('success', '该职位已发送过简历');

            return $this->redirect($this->generateUrl('position_show', array('positionId' => $positionId)));
        }

        $application = $applicationManager->createApplication($user, $position);
        $application->setTitle(sprintf('%s 应聘 %s 职位', $user->getScreenName(), $position->getPosition()));
        $application->setBody(sprintf('你好，以下是湖南英才网用户 %s 的简历，敬请查阅。谢谢。', $user->getScreenName()));

        $form = $this->getForm();
        $form->setData($application);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $applicationManager->updateApplication($application);

            $position->incrementNumApplications(1);
            $positionManager->updatePosition($position);

            $this->get('hr.mailer')->sendResumeEmailMessage($application);

            $this->get('session')->getFlashBag()->add('success', '简历已发送');

            return $this->redirect($this->generateUrl('position_show', array('positionId' => $positionId)));
        }

        return $this->render('HRPositionBundle:Application:new.html.twig', array(
            'position' => $position,
            'user'     => $user,
            'form'     => $form->createView()
        ));
    }

    public function sentAction()
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')
            ->add('发出的简历');

        $pager = $this->getApplicationManager()->findApplicationsBySender($user, $this->getRequest()->get('page', 1));

        return $this->render('HRPositionBundle:Application:sent.html.twig', array(
            'pager' => $pager
        ));
    }

    public function receivedAction()
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')
            ->add('收到的简历');

        $pager = $this->getApplicationManager()->findApplicationsByReceiver($user, $this->getRequest()->get('page', 1));

        return $this->render('HRPositionBundle:Application:received.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getForm()
    {
        return $this->get('application.form');
    }

    /**
     * @return \HR\PositionBundle\EntityManager\ApplicationManager
     */
    private function getApplicationManager()
    {
        return $this->get('application.manager');
    }

    /**
     * @return \HR\PositionBundle\EntityManager\PositionManager
     */
    private function getPositionManager()
    {
        return $this->get('position.manager.default');
    }
}