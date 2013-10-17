<?php
namespace HR\OAuthBundle\Model;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface ConnectInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set provider
     *
     * @param string $provider
     *
     * @return $this
     */
    public function setProvider($provider);

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider();

    /**
     * Set identification
     *
     * @param string $identification
     *
     * @return $this
     */
    public function setIdentification($identification);

    /**
     * Get identification
     *
     * @return string
     */
    public function getIdentification();

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();
}