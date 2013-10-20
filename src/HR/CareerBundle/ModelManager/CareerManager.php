<?php
namespace HR\CareerBundle\ModelManager;

use HR\CareerBundle\Model\CareerInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class CareerManager implements CareerManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createCareer(UserInterface $user)
    {
        $class = $this->getClass();

        /** @var \HR\CareerBundle\Model\CareerInterface $career */
        $career = new $class();
        $career->setUser($user);

        return $career;
    }

    /**
     * {@inheritdoc}
     */
    public function updateCareer(CareerInterface $career)
    {
        if (null === $career->getUser()) {
            throw new \InvalidArgumentException('The career must have a user');
        }

        $this->doUpdateCareer($career);
    }

    protected abstract function doUpdateCareer(CareerInterface $career);
}