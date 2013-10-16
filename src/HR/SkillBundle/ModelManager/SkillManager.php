<?php
namespace HR\SkillBundle\ModelManager;

use HR\SkillBundle\Model\SkillInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class SkillManager implements SkillManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createSkill(UserInterface $user)
    {
        $class = $this->getClass();

        /** @var \HR\SkillBundle\Model\SkillInterface $skill */
        $skill = new $class;
        $skill->setUser($user);

        return $skill;
    }

    /**
     * {@inheritdoc}
     */
    public function updateSkill(SkillInterface $skill)
    {
        if (null === $skill->getUser()) {
            throw new \InvalidArgumentException('The position must have a user');
        }

        $this->doUpdateSkill($skill);
    }

    protected abstract function doUpdateSkill(SkillInterface $skill);
}