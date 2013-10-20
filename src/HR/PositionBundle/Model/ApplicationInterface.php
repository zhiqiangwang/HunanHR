<?php
namespace HR\PositionBundle\Model;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface ApplicationInterface
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
     * @param PositionInterface $position
     *
     * @return $this
     */
    public function setPosition(PositionInterface $position);

    /**
     * @return PositionInterface
     */
    public function getPosition();

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
     * @param bool $boolean
     *
     * @return $this
     */
    public function setIsRead($boolean);

    /**
     * @return boolean
     */
    public function isRead();

    /**
     * @return mixed
     */
    public function getCreatedAt();
}