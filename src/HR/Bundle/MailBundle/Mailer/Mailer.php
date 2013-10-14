<?php
namespace HR\Bundle\MailBundle\Mailer;

use HR\Bundle\UserBundle\Model\UserInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class Mailer implements MailerInterface
{
    protected $mailer;
    protected $router;
    protected $twig;
    protected $parameters;

    public function __construct(\Swift_Mailer $mailer, RouterInterface $router, \Twig_Environment $twig, array $parameters)
    {
        $this->mailer     = $mailer;
        $this->router     = $router;
        $this->twig       = $twig;
        $this->parameters = $parameters;
    }

    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['template']['confirmation'];
        $url      = $this->router->generate('register_confirm', array('token' => $user->getConfirmationToken()), true);
        $context  = array(
            'user'            => $user,
            'confirmationUrl' => $url
        );

        $this->sendMessage($template, $context, $this->parameters['from_email']['confirmation'], $user->getEmail());
    }

    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['template']['resetting'];
        $url      = $this->router->generate('user_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $context  = array(
            'user'            => $user,
            'confirmationUrl' => $url
        );
        $this->sendMessage($template, $context, $this->parameters['from_email']['resetting'], $user->getEmail());
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendMessage($templateName, $context, $fromEmail, $toEmail)
    {
        $template = $this->twig->loadTemplate($templateName);
        $subject  = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($textBody, 'text/plain')
            ->setCharset('UTF-8');

        $this->mailer->send($message);
    }
}