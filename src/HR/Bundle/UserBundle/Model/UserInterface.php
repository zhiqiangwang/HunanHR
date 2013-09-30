<?php
namespace HR\Bundle\UserBundle\Model;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User Interface
 *
 * @package HR\Bundle\UserBundle\Entity
 * @author  Wenming Tang <tang@babyfamily.com>
 */
interface UserInterface extends AdvancedUserInterface
{
    const ROLE_DEFAULT     = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username);

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPlainPassword($password);

    /**
     * @return string
     */
    public function getPlainPassword();

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password);

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $screenName
     *
     * @return $this
     */
    public function setScreenName($screenName);

    /**
     * @return string
     */
    public function getScreenName();

    /**
     * @param string $realName
     *
     * @return $this
     */
    public function setRealName($realName);

    /**
     * @return string
     */
    public function getRealName();

    /**
     * @param string $gender
     *
     * @return $this
     */
    public function setGender($gender);

    /**
     * @return string
     */
    public function getGender();

    /**
     * @param string $avatarUrl
     *
     * @return $this
     */
    public function setAvatarUrl($avatarUrl);

    /**
     * @return string
     */
    public function getAvatarUrl();

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles);

    /**
     * @param string $role
     *
     * @return $this
     */
    public function addRole($role);

    /**
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role);

    /**
     * @param string $role
     *
     * @return $this
     */
    public function removeRole($role);

    /**
     * @param boolean $boolean
     *
     * @return $this
     */
    public function setExpired($boolean);

    /**
     * @param \Datetime $datetime
     *
     * @return $this
     */
    public function setExpiresAt(\Datetime $datetime);

    /**
     * @param boolean $boolean
     *
     * @return $this
     */
    public function setCredentialsExpired($boolean);

    /**
     * @param \Datetime $datetime
     *
     * @return $this
     */
    public function setCredentialsExpiresAt(\Datetime $datetime);

    /**
     * @param boolean $boolean
     *
     * @return $this
     */
    public function setEnabled($boolean);

    /**
     * @param boolean $boolean
     *
     * @return $this
     */
    public function setLocked($boolean);
}