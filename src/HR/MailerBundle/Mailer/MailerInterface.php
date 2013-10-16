<?php
namespace HR\MailerBundle\Mailer;

use HR\JobBundle\Model\DeliveryInterface;
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
     * @param DeliveryInterface $delivery
     *
     * @return void
     */
    public function sendResumeEmailMessage(DeliveryInterface $delivery);
}