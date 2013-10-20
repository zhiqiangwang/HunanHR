<?php
namespace HR\CareerBundle\ModelManager;

use HR\CareerBundle\Model\CareerInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface CareerManagerInterface
{
    /**
     * @param UserInterface $user
     *
     * @return CareerInterface
     */
    public function createCareer(UserInterface $user);

    /**
     * @param CareerInterface $career
     *
     * @return void
     */
    public function updateCareer(CareerInterface $career);

    /**
     * @param UserInterface $user
     *
     * @return CareerInterface
     */
    public function findCareersByUser(UserInterface $user);

    /**
     * @param int $careerId
     *
     * @return CareerInterface
     */
    public function findCareerById($careerId);

    /**
     * @param CareerInterface $career
     *
     * @return void
     */
    public function deleteCareer(CareerInterface $career);

    /**
     * @return string
     */
    public function getClass();
}