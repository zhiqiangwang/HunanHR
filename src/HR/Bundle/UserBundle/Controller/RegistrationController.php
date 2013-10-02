<?php
namespace HR\Bundle\UserBundle\Controller;

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
        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->get('user.form.registration');

        /** @var \HR\Bundle\UserBundle\EntityManager\UserManager $userManager */
        $userManager = $this->get('user.manager');
        $user        = $userManager->createUser();

        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('home'));
        }

        return array(
            'form' => $form->createView()
        );
    }
}