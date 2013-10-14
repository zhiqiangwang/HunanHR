<?php
namespace HR\Bundle\UserBundle\Controller;

use HR\Bundle\UserBundle\Event\FilterUserResponseEvent;
use HR\Bundle\UserBundle\UserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ProfileController extends Controller
{
    /**
     * @Template()
     */
    public function editAction(Request $request)
    {
        if (null == $user = $this->getUser()) {
            throw new AccessDeniedException();
        }

        $this->get('breadcrumb')->add('设置');

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('user.form.profile');
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getUserManager()->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', '基本资料已更新');

            $response = $this->redirect($this->generateUrl('profile_edit'));

            $dispatcher->dispatch(UserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function showAction($userId)
    {
        $user = $this->getUserManager()->findUserBy(array('id' => $userId));

        if (null == $user) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')
            ->add($user->getScreenName(), $this->generateUrl('profile_show', array('userId' => $userId)));

        $pager = $this->getJobManager()->findJobsPagerByUser($user);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        return array(
            'user'  => $user,
            'pager' => $pager,
        );
    }

    /**
     * @Template()
     */
    public function jobsAction(Request $request, $userId)
    {
        $user = $this->getUserManager()->findUserBy(array('id' => $userId));

        if (null == $user) {
            throw $this->createNotFoundException();
        }

        $this->get('breadcrumb')
            ->add($user->getScreenName(), $this->generateUrl('profile_show', array('userId' => $userId)))
            ->add('全部职位');

        $pager = $this->getJobManager()->findJobsPagerByUser($user, $request->get('page'));

        if (!$user) {
            throw $this->createNotFoundException();
        }

        return array(
            'user'  => $user,
            'pager' => $pager,
        );
    }

    /**
     * @return \HR\Bundle\UserBundle\EntityManager\UserManager
     */
    private function getUserManager()
    {
        return $this->get('user.user_manager');
    }

    /**
     * @return \HR\Bundle\JobBundle\EntityManager\JobManager
     */
    private function getJobManager()
    {
        return $this->get('job.manager.default');
    }
}