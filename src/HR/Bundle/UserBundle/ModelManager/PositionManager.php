<?php
namespace HR\Bundle\UserBundle\ModelManager;
use HR\Bundle\UserBundle\Model\PositionInterface;
use HR\Bundle\UserBundle\Model\UserInterface;
use InvalidArgumentException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class PositionManager implements PositionManagerInterface
{
    public function createPosition(UserInterface $user)
    {
        $class    = $this->getClass();
        $position = new $class();

        $position->setUser($user);

        return $position;
    }

    public function updatePosition(PositionInterface $position)
    {
        if (null === $position->getUser()) {
            throw new InvalidArgumentException('The position must have a user');
        }

        $this->doUpdatePosition($position);
    }

    public abstract function doUpdatePosition(PositionInterface $position);
}