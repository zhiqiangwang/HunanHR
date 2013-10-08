<?php
namespace HR\Bundle\PositionBundle\Model;

use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class Position implements PositionInterface
{
    protected $id;

    protected $title;

    protected $companyName;

    protected $startDate;

    protected $endDate;

    protected $summary;

    protected $user;

    protected $createdAt;

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
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSummary()
    {
        return $this->summary;
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
}