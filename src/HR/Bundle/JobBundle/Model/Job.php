<?php
namespace HR\Bundle\JobBundle\Model;

use HR\Bundle\LocationBundle\Entity\City;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class Job implements JobInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var integer
     */
    protected $type;

    /**
     * @var string
     */
    protected $skills;

    /**
     * @var string
     */
    protected $companyName;

    /**
     * @var string
     */
    protected $companyDescription;

    /**
     * @var City
     */
    protected $city;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $contactEmail;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var UserInterface
     */
    protected $user;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
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
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

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
    public function setCompanyDescription($companyDescription)
    {
        $this->companyDescription = $companyDescription;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompanyDescription()
    {
        return $this->companyDescription;
    }

    /**
     * {@inheritdoc}
     */
    public function setCity(City $city)
    {
        $this->city = $city;
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * {@inheritdoc}
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
