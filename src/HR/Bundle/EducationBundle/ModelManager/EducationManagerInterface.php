<?php
namespace HR\Bundle\EducationBundle\ModelManager;

use HR\Bundle\EducationBundle\Model\EducationInterface;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface EducationManagerInterface
{
    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function createEducation(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return array of education
     */
    public function findEducationsByUser(UserInterface $user);

    /**
     * @param int $id
     *
     * @return $this
     */
    public function findEducationById($id);

    /**
     * @param EducationInterface $education
     *
     * @return void
     */
    public function updateEducation(EducationInterface $education);

    /**
     * @param EducationInterface $education
     *
     * @return void
     */
    public function deleteEducation(EducationInterface $education);

    /**
     * @return string
     */
    public function getClass();
}