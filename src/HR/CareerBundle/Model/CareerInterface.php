<?php
namespace HR\CareerBundle\Model;

use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface CareerInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $title
     *
     * @return string
     */
    public function setTitle($title);

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
     * @param int $startDate
     *
     * @return $this
     */
    public function setStartDate($startDate);

    /**
     * @return int
     */
    public function getStartDate();

    /**
     * @param int $endDate
     *
     * @return $this
     */
    public function setEndDate($endDate);

    /**
     * @return int
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
     * @param UserInterface $user
     *
     * @return $this
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @return \Datetime
     */
    public function getCreatedAt();
}