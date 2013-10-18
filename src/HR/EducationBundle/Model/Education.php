<?php
namespace HR\EducationBundle\Model;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class Education implements EducationInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $schoolName;

    /**
     * @var integer
     */
    protected $degree;

    /**
     * @var integer
     */
    protected $startDate;

    /**
     * @var integer
     */
    protected $endDate;

    /**
     * @var string
     */
    protected $summary;

    /**
     * @var \DateTime
     */
    protected $createdAt;

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
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSchoolName()
    {
        return $this->schoolName;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
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
}
