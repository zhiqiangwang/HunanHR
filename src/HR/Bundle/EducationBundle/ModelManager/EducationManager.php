<?php
namespace HR\Bundle\EducationBundle\ModelManager;

use HR\Bundle\EducationBundle\Model\EducationInterface;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class EducationManager implements EducationManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createEducation(UserInterface $user)
    {
        $class = $this->getClass();

        /** @var \HR\Bundle\EducationBundle\Model\EducationInterface $education */
        $education = new $class;
        $education->setUser($user);

        return $education;
    }

    /**
     * {@inheritdoc}
     */
    public function updateEducation(EducationInterface $education)
    {
        if (null === $education->getUser()) {
            throw new \InvalidArgumentException('The position must have a user');
        }

        $this->doUpdateEducation($education);
    }

    protected abstract function doUpdateEducation(EducationInterface $education);
}