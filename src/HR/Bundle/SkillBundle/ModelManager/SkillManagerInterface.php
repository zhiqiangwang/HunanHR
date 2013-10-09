<?php
namespace HR\Bundle\SkillBundle\ModelManager;

use HR\Bundle\SkillBundle\Model\SkillInterface;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface SkillManagerInterface
{
    /**
     * @param UserInterface $user
     *
     * @return SkillInterface
     */
    public function createSkill(UserInterface $user);

    /**
     * @param SkillInterface $skill
     *
     * @return void
     */
    public function updateSkill(SkillInterface $skill);

    /**
     * @param UserInterface $user
     *
     * @return array
     */
    public function findSkillsByUser(UserInterface $user);

    /**
     * @param int $id
     *
     * @return SkillInterface
     */
    public function findSkillById($id);

    /**
     * @param SkillInterface $skill
     *
     * @return void
     */
    public function deleteSkill(SkillInterface $skill);

    /**
     * @return string
     */
    public function getClass();
}