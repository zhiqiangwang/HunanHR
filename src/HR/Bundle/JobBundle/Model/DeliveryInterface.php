<?php
namespace HR\Bundle\JobBundle\Model;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface DeliveryInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $body
     *
     * @return $this
     */
    public function setBody($body);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param JobInterface $job
     *
     * @return $this
     */
    public function setJob(JobInterface $job);

    /**
     * @return JobInterface
     */
    public function getJob();

    /**
     * @param UserInterface $receiver
     */
    public function setReceiver(UserInterface $receiver);

    /**
     * @return UserInterface
     */
    public function getReceiver();

    /**
     * @param UserInterface $sender
     */
    public function setSender(UserInterface $sender);

    /**
     * @return UserInterface
     */
    public function getSender();

    /**
     * @return mixed
     */
    public function getCreatedAt();
}