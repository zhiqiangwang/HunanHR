<?php
namespace HR\Bundle\MailBundle\Mailer;

use HR\Bundle\UserBundle\Model\UserInterface;

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
}