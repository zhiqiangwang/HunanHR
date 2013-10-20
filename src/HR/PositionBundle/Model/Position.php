<?php
namespace HR\PositionBundle\Model;

use HR\LocationBundle\Entity\City;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class Position implements PositionInterface
{
    /**
     * @var integer
     *
     */
    protected $id;

    /**
     * @var string
     */
    protected $position;

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
     * @var integer
     */
    protected $numViews;

    /**
     * @var integer
     */
    protected $numApplications;

    /**
     * @var bool
     */
    protected $isDeleted;

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
        $this->createdAt       = new \Datetime();
        $this->isDeleted       = false;
        $this->numViews        = 0;
        $this->numApplications = 0;
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
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
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
    public function incrementNumViews($by)
    {
        $this->numViews += intval($by);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumViews()
    {
        return $this->numViews;
    }

    /**
     * {@inheritdoc}
     */
    public function incrementNumApplications($by)
    {
        $this->numApplications += intval($by);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumApplications()
    {
        return $this->numApplications;
    }

    /**
     * {@inheritdoc}
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isDeleted()
    {
        return $this->isDeleted;
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
