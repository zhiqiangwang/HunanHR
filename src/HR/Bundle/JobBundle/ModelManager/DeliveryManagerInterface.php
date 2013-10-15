<?php
namespace HR\Bundle\JobBundle\ModelManager;
use HR\Bundle\JobBundle\Model\DeliveryInterface;
use HR\Bundle\JobBundle\Model\JobInterface;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface DeliveryManagerInterface
{
    /**
     * @param UserInterface $sender
     * @param JobInterface  $job
     *
     * @return DeliveryInterface
     */
    public function createDelivery(UserInterface $sender, JobInterface $job);

    /**
     * @param DeliveryInterface $delivery
     *
     * @return void
     */
    public function updateDelivery(DeliveryInterface $delivery);

    /**
     * @param UserInterface $sender
     *
     * @return DeliveryInterface[]
     */
    public function findDeliveriesBySender(UserInterface $sender);

    /**
     * @param UserInterface $sender
     * @param JobInterface  $job
     *
     * @return DeliveryInterface
     */
    public function findDeliveryBySenderAndJob(UserInterface $sender, JobInterface $job);

    /**
     * @param UserInterface $receiver
     *
     * @return DeliveryInterface[]
     */
    public function findDeliveriesByReceiver(UserInterface $receiver);

    /**
     * @param int $id
     *
     * @return DeliveryInterface
     */
    public function findDeliveryById($id);

    /**
     * @return string
     */
    public function getClass();
}