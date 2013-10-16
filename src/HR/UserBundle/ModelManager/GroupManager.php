<?php
namespace HR\UserBundle\ModelManager;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class GroupManager implements GroupManagerInterface
{
    /**
     * {@inheritDoc}
     */
    public function createGroup($name)
    {
        $class = $this->getClass();

        return new $class($name);
    }
    /**
     * {@inheritDoc}
     */
    public function findGroupByName($name)
    {
        return $this->findGroupBy(array('name' => $name));
    }
}