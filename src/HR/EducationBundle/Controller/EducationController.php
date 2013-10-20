<?php
namespace HR\EducationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class EducationController extends Controller
{
    public function indexAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('教育经历');

        /** @var \HR\EducationBundle\EntityManager\EducationManager $educationManager */
        $educationManager = $this->get('education.manager');
        $educations       = $educationManager->findEducationsByUser($user);

        // new education
        $education = $educationManager->createEducation($user);

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('education.form');
        $form->setData($education);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $educationManager->updateEducation($education);

            $this->get('session')->getFlashBag()->add('success', '教育经历已保存');

            return $this->redirect($this->generateUrl('education_list'));
        }

        return $this->render('HREducationBundle:Education:index.html.twig', array(
            'educations' => $educations,
            'form'       => $form->createView()
        ));
    }

    public function editAction(Request $request, $educationId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('教育经历', $this->generateUrl('education_list'))->add('编辑教育经历');

        /** @var \HR\EducationBundle\EntityManager\EducationManager $educationManager */
        $educationManager = $this->get('education.manager');
        $education        = $educationManager->findEducationById($educationId);

        if (null == $education || !$user->equals($education->getUser())) {
            throw $this->createNotFoundException();
        }

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('education.form');
        $form->setData($education);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $educationManager->updateEducation($education);

            $this->get('session')->getFlashBag()->add('success', '教育经历已更新');

            return $this->redirect($this->generateUrl('education_list'));
        }

        return $this->render('HREducationBundle:Education:edit.html.twig', array(
            'form'      => $form->createView(),
            'education' => $education
        ));
    }

    public function deleteAction($educationId)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        /** @var \HR\EducationBundle\EntityManager\EducationManager $educationManager */
        $educationManager = $this->get('education.manager');
        $education        = $educationManager->findEducationById($educationId);

        if (null == $education || !$user->equals($education->getUser())) {
            throw $this->createNotFoundException();
        }

        $educationManager->deleteEducation($education);

        $this->get('session')->getFlashBag()->add('success', '教育经历已删除');

        return $this->redirect($this->generateUrl('education_list'));
    }
}
