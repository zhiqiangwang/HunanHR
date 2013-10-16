<?php
namespace HR\JobBundle\ModelManager;
use HR\UserBundle\Model\UserInterface;
use HR\JobBundle\Model\DeliveryInterface;
use HR\JobBundle\Model\JobInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class DeliveryManager implements DeliveryManagerInterface
{
    /**
     * @param UserInterface $sender
     * @param JobInterface  $job
     *
     * @return DeliveryInterface
     */
    public function createDelivery(UserInterface $sender, JobInterface $job)
    {
        $class = $this->getClass();

        /** @var DeliveryInterface $delivery */
        $delivery = new $class;
        $delivery->setSender($sender);
        $delivery->setJob($job);
        $delivery->setReceiver($job->getUser());

        return $delivery;
    }
}