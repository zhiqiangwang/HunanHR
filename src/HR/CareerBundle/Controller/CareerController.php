<?php
namespace HR\CareerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class CareerController extends Controller
{
    public function indexAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('职业经历');

        /** @var \HR\CareerBundle\EntityManager\CareerManager $careerManager */
        $careerManager = $this->get('career.manager');
        $careers       = $careerManager->findCareersByUser($user);

        // new career
        $career = $careerManager->createCareer($user);

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('career.form');
        $form->setData($career);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $careerManager->updateCareer($career);

            $this->get('session')->getFlashBag()->add('success', '职业经历已保存');

            return $this->redirect($this->generateUrl('career_list'));
        }

        return $this->render('HRCareerBundle:Career:index.html.twig', array(
            'careers' => $careers,
            'form'    => $form->createView()
        ));
    }

    public function editAction(Request $request, $careerId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('职业经历', $this->generateUrl('career_list'))->add('编辑职业经历');

        /** @var \HR\CareerBundle\EntityManager\CareerManager $careerManager */
        $careerManager = $this->get('career.manager');
        $career        = $careerManager->findCareerById($careerId);

        if (null == $career || !$user->equals($career->getUser())) {
            throw $this->createNotFoundException();
        }

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('career.form');
        $form->setData($career);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $careerManager->updateCareer($career);

            $this->get('session')->getFlashBag()->add('success', '职业经历已更新');

            return $this->redirect($this->generateUrl('career_list'));
        }

        return $this->render('HRCareerBundle:Career:edit.html.twig', array(
            'form'   => $form->createView(),
            'career' => $career
        ));
    }

    public function deleteAction($careerId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        /** @var \HR\CareerBundle\EntityManager\CareerManager $careerManager */
        $careerManager = $this->get('career.manager');
        $career        = $careerManager->findCareerById($careerId);

        if (null == $career || !$user->equals($career->getUser())) {
            throw $this->createNotFoundException();
        }

        $careerManager->deleteCareer($career);

        $this->get('session')->getFlashBag()->add('success', '职业经历已删除');

        return $this->redirect($this->generateUrl('career_list'));
    }
}