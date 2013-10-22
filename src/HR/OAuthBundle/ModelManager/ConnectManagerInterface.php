<?php
namespace HR\OAuthBundle\ModelManager;

use HR\OAuthBundle\Model\ConnectInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface ConnectManagerInterface
{
    /**
     * @param UserInterface $user
     *
     * @return ConnectInterface
     */
    public function createConnect(UserInterface $user);

    /**
     * @param array $criteria
     *
     * @return ConnectInterface
     */
    public function findConnectBy(array $criteria);

    /**
     * @param ConnectInterface $connect
     *
     * @return void
     */
    public function updateConnect(ConnectInterface $connect);

    /**
     * @param ConnectInterface $connect
     *
     * @return void
     */
    public function deleteConnect(ConnectInterface $connect);

    /**
     * @return string
     */
    public function getClass();
}