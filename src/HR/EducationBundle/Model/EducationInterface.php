<?php
namespace HR\EducationBundle\Model;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface EducationInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set schoolName
     *
     * @param string $schoolName
     *
     * @return $this
     */
    public function setSchoolName($schoolName);

    /**
     * Get schoolName
     *
     * @return string
     */
    public function getSchoolName();

    /**
     * Set degree
     *
     * @param integer $degree
     *
     * @return $this
     */
    public function setDegree($degree);

    /**
     * Get degree
     *
     * @return integer
     */
    public function getDegree();

    /**
     * @return string
     */
    public function getDegreeName();

    /**
     * Set startDate
     *
     * @param integer $startDate
     *
     * @return $this
     */
    public function setStartDate($startDate);

    /**
     * Get startDate
     *
     * @return integer
     */
    public function getStartDate();

    /**
     * Set endDate
     *
     * @param integer $endDate
     *
     * @return $this
     */
    public function setEndDate($endDate);

    /**
     * Get endDate
     *
     * @return integer
     */
    public function getEndDate();

    /**
     * @param string $summary
     *
     * @return $this
     */
    public function setSummary($summary);

    /**
     * @return string
     */
    public function getSummary();

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt();

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