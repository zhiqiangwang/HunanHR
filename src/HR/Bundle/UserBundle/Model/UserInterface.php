<?php
namespace HR\Bundle\UserBundle\Model;

use HR\Bundle\EducationBundle\Model\EducationInterface;
use HR\Bundle\JobBundle\Model\JobInterface;
use HR\Bundle\SkillBundle\Entity\Skill;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use HR\Bundle\PositionBundle\Model\PositionInterface;

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
     * @param string $jobTitle
     *
     * @return $this
     */
    public function setJobTitle($jobTitle);

    /**
     * @return string
     */
    public function getJobTitle();

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
     * @param PositionInterface $position
     *
     * @return $this
     */
    public function addPosition(PositionInterface $position);

    /**
     * @param PositionInterface $position
     *
     * @return $this
     */
    public function removePosition(PositionInterface $position);

    /**
     * @return array of Position
     */
    public function getPositions();

    /**
     * @param EducationInterface $education
     *
     * @return $this
     */
    public function addEducation(EducationInterface $education);

    /**
     * @param EducationInterface $education
     *
     * @return $this
     */
    public function removeEducation(EducationInterface $education);

    /**
     * @return array of education
     */
    public function getEducations();

    /**
     * @param Skill $skill
     *
     * @return $this
     */
    public function addSkill(Skill $skill);

    /**
     * @param Skill $skill
     *
     * @return $this
     */
    public function removeSkill(Skill $skill);

    /**
     * @return array
     */
    public function getSkills();

    /**
     * @param JobInterface $job
     *
     * @return $this
     */
    public function addJob(JobInterface $job);

    /**
     * @param JobInterface $job
     *
     * @return void
     */
    public function removeJob(JobInterface $job);

    /**
     * @return array
     */
    public function getJobs();

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