<?php
namespace HR\Bundle\UserBundle\Model;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface GroupableInterface
{
    /**
     * @return GroupInterface[]
     */
    public function getGroups();

    /**
     * @return array
     */
    public function getGroupNames();

    /**
     * @param string $name Name of the group
     *
     * @return Boolean
     */
    public function hasGroup($name);

    /**
     * @param GroupInterface $group
     *
     * @return self
     */
    public function addGroup(GroupInterface $group);

    /**
     * @param GroupInterface $group
     *
     * @return self
     */
    public function removeGroup(GroupInterface $group);
}