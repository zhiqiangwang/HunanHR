<?php
namespace HR\JobBundle\Model;

use HR\LocationBundle\Entity\City;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface JobInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set position
     *
     * @param string $position
     *
     * @return $this
     */
    public function setPosition($position);

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition();

    /**
     * Set description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return $this
     */
    public function setType($type);

    /**
     * Get type
     *
     * @return integer
     */
    public function getType();

    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return $this
     */
    public function setCompanyName($companyName);

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName();

    /**
     * Set companyDescription
     *
     * @param string $companyDescription
     *
     * @return $this
     */
    public function setCompanyDescription($companyDescription);

    /**
     * Get companyDescription
     *
     * @return string
     */
    public function getCompanyDescription();

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return $this
     */
    public function setContactEmail($contactEmail);

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail();

    /**
     * @param City $city
     *
     * @return $this
     */
    public function setCity(City $city);

    /**
     * @return City
     */
    public function getCity();

    /**
     * @param $location
     *
     * @return $this
     */
    public function setLocation($location);

    /**
     * @return string
     */
    public function getLocation();

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return \Datetime
     */
    public function getUpdatedAt();

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();
}