<?php
namespace HR\UserBundle\Model;

use HR\OAuthBundle\Model\ConnectInterface;
use HR\PositionBundle\Model\PositionInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User Interface
 *
 * @package HR\UserBundle\Entity
 * @author  Wenming Tang <tang@babyfamily.com>
 */
interface UserInterface extends AdvancedUserInterface, \Serializable
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
     * @return string
     */
    public function getGenderName();

    /**
     * @param string $birthday
     *
     * @return $this
     */
    public function setBirthday($birthday);

    /**
     * @return string
     */
    public function getBirthday();

    /**
     * @param int $degree
     *
     * @return $this
     */
    public function setDegree($degree);

    /**
     * @return int
     */
    public function getDegree();

    /**
     * @return int
     */
    public function getDegreeName();

    /**
     * @param string $positionTitle
     *
     * @return $this
     */
    public function setPositionTitle($positionTitle);

    /**
     * @return string
     */
    public function getPositionTitle();

    /**
     * @param string $companyName
     *
     * @return $this
     */
    public function setCompanyName($companyName);

    /**
     * @return string
     */
    public function getCompanyName();

    /**
     * @param string $phoneNumber
     *
     * @return $this
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @param string $homepage
     *
     * @return $this
     */
    public function setHomepage($homepage);

    /**
     * @return string
     */
    public function getHomepage();

    /**
     * @param string $bio
     *
     * @return $this
     */
    public function setBio($bio);

    /**
     * @return string
     */
    public function getBio();

    /**
     * @param string $avatarSmallUrl
     *
     * @return $this
     */
    public function setAvatarSmallUrl($avatarSmallUrl);

    /**
     * @return string
     */
    public function getAvatarSmallUrl();

    /**
     * @param string $avatarBigUrl
     *
     * @return $this
     */
    public function setAvatarBigUrl($avatarBigUrl);

    /**
     * @return string
     */
    public function getAvatarBigUrl();

    /**
     * @param int $by
     *
     * @return $this
     */
    public function incrementNumPositions($by);

    /**
     * @param int $by
     *
     * @return $this
     */
    public function subtractNumPositions($by);

    /**
     * @return int
     */
    public function getNumPositions();

    /**
     * @param bool $boolean
     *
     * @return $this
     */
    public function setEmailConfirmed($boolean);

    /**
     * @return bool
     */
    public function isEmailConfirmed();

    /**
     * @param int $confirmationToken
     *
     * @return $this
     */
    public function setConfirmationToken($confirmationToken);

    /**
     * @return string
     */
    public function getConfirmationToken();

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setPasswordRequestedAt(\DateTime $date = null);

    /**
     * @param int $ttl
     *
     * @return bool
     */
    public function isPasswordRequestNonExpired($ttl);

    /**
     * @param ConnectInterface $connect
     *
     * @return $this
     */
    public function addConnect(ConnectInterface $connect);

    /**
     * @param ConnectInterface $connect
     *
     * @return $this
     */
    public function removeConnect(ConnectInterface $connect);

    /**
     * @return ConnectInterface[]
     */
    public function getConnects();

    /**
     * @return CareerInterface[]
     */
    public function getCareers();

    /**
     * @return array of education
     */
    public function getEducations();

    /**
     * @return array
     */
    public function getSkills();

    /**
     * @param PositionInterface $position
     *
     * @return $this
     */
    public function addPosition(PositionInterface $position);

    /**
     * @param PositionInterface $position
     *
     * @return void
     */
    public function removePosition(PositionInterface $position);

    /**
     * @return array
     */
    public function getPositions();

    /**
     * @return boolean
     */
    public function isSuperAdmin();

    /**
     * @param bool $boolean
     *
     * @return $this
     */
    public function setSuperAdmin($boolean);

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

    /**
     * @return \Datetime
     */
    public function getCreatedAt();

    /**
     * @param \Datetime $lastLogin
     *
     * @return $this
     */
    public function setLastLogin($lastLogin);

    /**
     * @return string
     */
    public function getLastLogin();

    /**
     * @param string $lastLoginIp
     *
     * @return $this
     */
    public function setLastLoginIp($lastLoginIp);

    /**
     * @return string
     */
    public function getLastLoginIp();

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function equals(UserInterface $user);
}