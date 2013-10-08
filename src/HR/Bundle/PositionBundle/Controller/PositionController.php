<?php
namespace HR\Bundle\PositionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PositionController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('职业经历');

        /** @var \HR\Bundle\PositionBundle\EntityManager\PositionManager $positionManager */
        $positionManager = $this->get('position.manager');
        $positions       = $positionManager->findPositionByUser($user);

        // new position
        $position = $positionManager->createPosition($user);

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('position.form');
        $form->setData($position);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $positionManager->updatePosition($position);

            $this->get('session')->getFlashBag()->add('success', '职业经历已保存');

            return $this->redirect($this->generateUrl('position_list'));
        }

        return array(
            'positions' => $positions,
            'form'      => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function editAction(Request $request, $positionId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('职业经历', $this->generateUrl('position_list'))->add('编辑');

        /** @var \HR\Bundle\PositionBundle\EntityManager\PositionManager $positionManager */
        $positionManager = $this->get('position.manager');
        $position        = $positionManager->findPositionById($positionId);

        if (null == $position || !$user->equals($position->getUser())) {
            return $this->createNotFoundException();
        }

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('position.form');
        $form->setData($position);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $positionManager->updatePosition($position);

            $this->get('session')->getFlashBag()->add('success', '职业经历已更新');

            return $this->redirect($this->generateUrl('position_list'));
        }

        return array(
            'form'     => $form->createView(),
            'position' => $position
        );
    }

    public function deleteAction($positionId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        /** @var \HR\Bundle\PositionBundle\EntityManager\PositionManager $positionManager */
        $positionManager = $this->get('position.manager');
        $position        = $positionManager->findPositionById($positionId);

        if (null == $position || !$user->equals($position->getUser())) {
            return $this->createNotFoundException();
        }

        $positionManager->deletePosition($position);

        $this->get('session')->getFlashBag()->add('success', '职业经历已删除');

        return $this->redirect($this->generateUrl('position_list'));
    }
}