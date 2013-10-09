<?php
namespace HR\Bundle\UserBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use HR\Bundle\EducationBundle\Model\EducationInterface;
use HR\Bundle\PositionBundle\Model\PositionInterface;
use HR\Bundle\SkillBundle\Entity\Skill;

/**
 * User Model
 *
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class User implements UserInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $screenName;

    /**
     * @var string
     */
    protected $realName;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var string
     */
    protected $birthday;

    /**
     * @var int
     */
    protected $degree;

    /**
     * @var string
     */
    protected $jobTitle;

    /**
     * @var string
     */
    protected $companyName;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $homepage;

    /**
     * @var string
     */
    protected $bio;

    /**
     * @var string
     */
    protected $avatarSmallUrl;

    /**
     * @var string
     */
    protected $avatarBigUrl;

    /**
     * @var ArrayCollection
     */
    protected $positions;

    /**
     * @var ArrayCollection
     */
    protected $educations;

    /**
     * @var ArrayCollection
     */
    protected $skills;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var bool
     */
    protected $locked;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var bool
     */
    protected $expired;

    /**
     * @var \Datetime
     */
    protected $expiresAt;

    /**
     * @var bool
     */
    protected $credentialsExpired;

    /**
     * @var \Datetime
     */
    protected $credentialsExpiresAt;

    /**
     * @var \Datetime
     */
    protected $createdAt;

    /**
     * @var \Datetime
     */
    protected $lastLogin;

    /**
     * @var string
     */
    protected $lastLoginIp;

    public function __construct()
    {
        $this->locked             = false;
        $this->expired            = false;
        $this->credentialsExpired = false;
        $this->enabled            = true;
        $this->roles              = array();
        $this->salt               = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->createdAt          = new \Datetime();
        $this->positions          = new ArrayCollection();
        $this->educations         = new ArrayCollection();
        $this->skills             = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        return $this->setPlainPassword(null);
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * {@inheritdoc}
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * {@inheritdoc}
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * {@inheritdoc}
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * {@inheritdoc}
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * {@inheritdoc}
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * {@inheritdoc}
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * {@inheritdoc}
     */
    public function setAvatarSmallUrl($avatarSmallUrl)
    {
        $this->avatarSmallUrl = $avatarSmallUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatarSmallUrl()
    {
        return $this->avatarSmallUrl ?: 'img/default-avatar48.png';
    }

    /**
     * {@inheritdoc}
     */
    public function setAvatarBigUrl($avatarBigUrl)
    {
        $this->avatarBigUrl = $avatarBigUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatarBigUrl()
    {
        return $this->avatarBigUrl ?: 'img/default-avatar128.png';
    }

    /**
     * {@inheritdoc}
     */
    public function addPosition(PositionInterface $position)
    {
        $this->positions->add($position);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removePosition(PositionInterface $position)
    {
        $this->positions->removeElement($position);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * {@inheritdoc}
     */
    public function addEducation(EducationInterface $education)
    {
        $this->educations->add($education);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEducation(EducationInterface $education)
    {
        $this->educations->removeElement($education);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEducations()
    {
        return $this->educations;
    }

    /**
     * {@inheritdoc}
     */
    public function addSkill(Skill $skill)
    {
        $this->skills->add($skill);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSkill(Skill $skill)
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSkills()
    {
        return $this->skills;
    }


    /**
     * {@inheritdoc}
     */
    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles   = $this->roles;
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }

    /**
     * {@inheritdoc}
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($boolean)
    {
        $this->enabled = (Boolean)$boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocked($boolean)
    {
        $this->locked = (Boolean)$boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    /**
     * {@inheritdoc}
     */
    public function setExpired($expired)
    {
        $this->expired = (Boolean)$expired;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        if (true == $this->expired) {
            return false;
        }

        if (null !== $this->expiresAt && $this->expiresAt->getTimestamp() < time()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function setExpiresAt(\Datetime $datetime)
    {
        $this->expiresAt = $datetime;

        return $this;
    }

    /**
     * @param boolean $boolean
     *
     * @return $this
     */
    public function setCredentialsExpired($boolean)
    {
        $this->credentialsExpired = $boolean;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCredentialsExpiresAt(\Datetime $datetime)
    {
        $this->credentialsExpiresAt = $datetime;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        if (true == $this->credentialsExpired) {
            return false;
        }

        if (null !== $this->credentialsExpiresAt && $this->credentialsExpiresAt->getTimestamp() < time()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->lastLoginIp = $lastLoginIp;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastLoginIp()
    {
        return $this->lastLoginIp;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(UserInterface $user)
    {
        return $this->id == $user->getId();
    }
}