<?php
namespace HR\UserBundle\ModelManager;

use HR\UserBundle\Model\GroupInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface GroupManagerInterface
{
    /**
     * @param string $name
     *
     * @return GroupInterface
     */
    public function createGroup($name);

    /**
     * @param GroupInterface $group
     *
     * @return void
     */
    public function deleteGroup(GroupInterface $group);

    /**
     * @param array $criteria
     *
     * @return GroupInterface
     */
    public function findGroupBy(array $criteria);

    /**
     * @param string $name
     *
     * @return GroupInterface
     */
    public function findGroupByName($name);

    /**
     * @return GroupInterface[]
     */
    public function findGroups();

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param GroupInterface $group
     *
     * @return void
     */
    public function updateGroup(GroupInterface $group);
}