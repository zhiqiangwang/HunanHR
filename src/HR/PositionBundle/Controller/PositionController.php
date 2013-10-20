<?php
namespace HR\PositionBundle\Controller;

use HR\PositionBundle\Event\PositionEvent;
use HR\PositionBundle\PositionEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PositionController extends Controller
{
    public function newAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('发布职位');

        $position = $this->getPositionManager()->createPosition($user);
        $position->setCompanyName($user->getCompanyName());
        $position->setContactEmail($user->getEmail());

        $form = $this->getForm();
        $form->setData($position);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getPositionManager()->updatePosition($position);

            $this->get('session')->getFlashBag()->add('success', '职位已发布');

            $this->getDispatcher()->dispatch(PositionEvents::POSITION_SAVE_COMPLETED, new PositionEvent($position));

            return $this->redirect($this->generateUrl('position_show', array('positionId' => $position->getId())));
        }

        return $this->render('HRPositionBundle:Position:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function showAction($positionId)
    {
        $position = $this->getPositionManager()->findPositionById($positionId);

        if (!$position) {
            throw $this->createNotFoundException();
        }

        $position->incrementNumViews(1);
        $this->get('position.manager.default')->updatePosition($position);

        $this->get('breadcrumb')->add($position->getPosition());

        return $this->render('HRPositionBundle:Position:show.html.twig', array(
            'position' => $position
        ));
    }

    public function editAction(Request $request, $positionId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $position = $this->getPositionManager()->findPositionById($positionId);

        if (null == $position) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')
            ->add($position->getPosition(), $this->generateUrl('position_show', array('positionId' => $position->getId())))
            ->add('编辑');

        if (!$this->get('position.acl')->canEdit($position)) {
            throw new AccessDeniedException();
        }

        $form = $this->getForm();
        $form->setData($position);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getPositionManager()->updatePosition($position);

            $this->get('session')->getFlashBag()->add('success', '职位已更新');

            $this->getDispatcher()->dispatch(PositionEvents::POSITION_EDIT_COMPLETED, new PositionEvent($position));

            return $this->redirect($this->generateUrl('position_show', array('positionId' => $position->getId())));
        }

        return $this->render('HRPositionBundle:Position:edit.html.twig', array(
            'form'     => $form->createView(),
            'position' => $position
        ));
    }

    public function deleteAction($positionId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $position = $this->getPositionManager()->findPositionById($positionId);

        if (null == $position) {
            throw $this->createNotFoundException();
        }

        if (!$this->get('position.acl')->canDelete($position)) {
            throw new AccessDeniedException();
        }

        $this->getPositionManager()->softDeletePosition($position);

        $this->getDispatcher()->dispatch(PositionEvents::POSITION_DELETE_COMPLETED, new PositionEvent($position));

        $this->get('session')->getFlashBag()->add('success', '职位已删除');

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @return \HR\PositionBundle\EntityManager\PositionManager $positionManager
     */
    private function getPositionManager()
    {
        return $this->get('position.manager.acl');
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getForm()
    {
        return $this->get('position.form');
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private function getDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }
}
