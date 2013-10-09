<?php
namespace HR\Bundle\UserBundle\Controller;

use HR\Bundle\UserBundle\Event\FilterUserResponseEvent;
use HR\Bundle\UserBundle\UserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RegistrationController extends Controller
{
    /**
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $this->get('breadcrumb')->add('注册');

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('user.form.registration');

        /** @var \HR\Bundle\UserBundle\EntityManager\UserManager $userManager */
        $userManager = $this->get('user.user_manager');

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();

        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', '注册完成，请完善您的资料。');

            $response = $this->redirect($this->generateUrl('profile_edit'));

            $dispatcher->dispatch(UserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return array(
            'form' => $form->createView()
        );
    }
}