<?php
namespace HR\EducationBundle\ModelManager;

use HR\EducationBundle\Model\EducationInterface;
use HR\UserBundle\Model\UserInterface;

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