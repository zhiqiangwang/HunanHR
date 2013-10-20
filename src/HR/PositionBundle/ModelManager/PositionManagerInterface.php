<?php
namespace HR\PositionBundle\ModelManager;

use HR\PositionBundle\Model\PositionInterface;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface PositionManagerInterface
{
    public function createPosition(UserInterface $user);

    public function findPositionsPagerByUser(UserInterface $user, $page = 1);

    public function findPositionsPagerByLatest($page = 1);

    public function findPositionById($id);

    public function findPositionByIds(array $idSet);

    public function findAllPositions();

    public function updatePosition(PositionInterface $position);

    public function softDeletePosition(PositionInterface $position);

    public function isNewPosition(PositionInterface $position);

    public function getClass();
}