<?php
namespace HR\EducationBundle\ModelManager;

use HR\EducationBundle\Model\EducationInterface;
use HR\UserBundle\Model\UserInterface;

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

        /** @var \HR\EducationBundle\Model\EducationInterface $education */
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