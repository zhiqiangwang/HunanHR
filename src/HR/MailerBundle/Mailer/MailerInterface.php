<?php
namespace HR\MailerBundle\Mailer;

use HR\PositionBundle\Model\ApplicationInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface MailerInterface
{
    /**
     * Send an email to a user to confirm the account creation
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function sendConfirmationEmailMessage(UserInterface $user);

    /**
     * Send an email to a user to confirm the password reset
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function sendResettingEmailMessage(UserInterface $user);

    /**
     * @param ApplicationInterface $application
     *
     * @return void
     */
    public function sendResumeEmailMessage(ApplicationInterface $application);
}