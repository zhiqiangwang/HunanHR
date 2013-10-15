<?php
namespace HR\Bundle\UserBundle\Controller;

use HR\Bundle\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ResettingController extends Controller
{
    /**
     * @Template()
     */
    public function requestAction()
    {
        $this->get('breadcrumb')->add('找回密码');

        return array();
    }

    public function sendEmailAction(Request $request)
    {
        $this->get('breadcrumb')->add('找回密码');

        $email = $request->request->get('email');

        $user = $this->getUserManager()->findUserByUsernameOrEmail($email);

        if (null === $user) {
            return $this->render('HRUserBundle:Resetting:request.html.twig', array('error' => '用户名或电子邮件地址无效'));
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('user_resetting_token_ttl'))) {
            return $this->render('HRUserBundle:Resetting:request.html.twig', array('error' => '请超过24小时候再次重置密码'));
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \HR\Bundle\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->container->get('user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->get('session')->set('user_resetting_email', $this->getObfuscatedEmail($user));

        $this->container->get('hr.mailer')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->container->get('user.user_manager')->updateUser($user);

        return $this->redirect($this->generateUrl('user_resetting_check_email'));
    }

    /**
     * @Template()
     */
    public function checkEmailAction()
    {
        $this->get('breadcrumb')->add('找回密码');

        $session = $this->get('session');
        $email   = $session->get('user_resetting_email');

        $session->remove('user_resetting_email');

        if (null == $email) {
            return $this->redirect($this->generateUrl('user_resetting_request'));
        }

        return array('email' => $email);
    }

    /**
     * @Template()
     */
    public function resetAction(Request $request, $token)
    {
        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this->container->get('user.form.resetting');

        $user = $this->getUserManager()->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        if (!$user->isPasswordRequestNonExpired($this->container->getParameter('user_resetting_token_ttl'))) {
            return $this->redirect($this->generateUrl('user_resetting_request'));
        }

        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);

            $this->getUserManager()->updateUser($user);

            $this->get('session')->getFlashBag()->add('success', '您的密码已重置，请登录。');

            return $this->redirect($this->generateUrl('login'));
        }

        return array(
            'token' => $token,
            'form'  => $form->createView()
        );
    }

    private function getObfuscatedEmail(UserInterface $user)
    {
        $email = $user->getEmail();
        if (false !== $pos = strpos($email, '@')) {
            $email = '...' . substr($email, $pos);
        }

        return $email;
    }

    /**
     * @return \HR\Bundle\UserBundle\EntityManager\UserManager
     */
    private function getUserManager()
    {
        return $this->get('user.user_manager');
    }
}