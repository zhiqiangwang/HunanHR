<?php
namespace HR\Bundle\JobBundle\Model;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class Delivery implements DeliveryInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var UserInterface
     */
    protected $sender;

    /**
     * @var UserInterface
     */
    protected $receiver;

    /**
     * @var UserInterface
     */
    protected $job;

    /**
     * @var \Datetime
     */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function setJob(JobInterface $job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiver(UserInterface $receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * {@inheritdoc}
     */
    public function setSender(UserInterface $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
