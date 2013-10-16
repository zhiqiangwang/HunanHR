<?php
namespace HR\UserBundle\Model;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface GroupInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $role
     *
     * @return $this
     */
    public function addRole($role);

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role);

    /**
     * @return array
     */
    public function getRoles();

    /**
     * @param string $role
     *
     * @return $this
     */
    public function removeRole($role);

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles);
}