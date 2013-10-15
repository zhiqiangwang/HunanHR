<?php
namespace HR\Bundle\JobBundle\ModelManager;
use HR\Bundle\UserBundle\Model\UserInterface;
use HR\Bundle\JobBundle\Model\DeliveryInterface;
use HR\Bundle\JobBundle\Model\JobInterface;

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