<?php
namespace HR\PositionBundle\ModelManager;

use HR\PositionBundle\Model\PositionInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class PositionManager implements PositionManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createPosition(UserInterface $user)
    {
        $class = $this->getClass();

        /** @var PositionInterface $position */
        $position = new $class();
        $position->setUser($user);

        return $position;
    }

    /**
     * {@inheritdoc}
     */
    public function updatePosition(PositionInterface $position)
    {
        if (null === $position->getUser()) {
            throw new \InvalidArgumentException('The position must have a user');
        }

        $position->setUpdatedAt(new \DateTime());
        $this->doUpdateEducation($position);
    }

    protected abstract function doUpdateEducation($position);
}