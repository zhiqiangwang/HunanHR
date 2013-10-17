<?php
namespace HR\OAuthBundle\ModelManager;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class ConnectManager implements ConnectManagerInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConnect(UserInterface $user)
    {
        $class = $this->getClass();

        /** @var \HR\OAuthBundle\Model\ConnectInterface $connect */
        $connect = new $class;
        $connect->setUser($user);

        return $connect;
    }
}