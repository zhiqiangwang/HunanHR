<?php
namespace HR\PositionBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use HR\PositionBundle\Model\ApplicationInterface;
use HR\PositionBundle\Model\PositionInterface;
use HR\PositionBundle\ModelManager\ApplicationManager as BaseApplicationManager;
use HR\UserBundle\Model\UserInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ApplicationManager extends BaseApplicationManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    public function __construct(EntityManager $em, $class)
    {
        $this->em         = $em;
        $this->repository = $this->em->getRepository($class);
        $this->class      = $this->em->getClassMetadata($class)->getName();
    }

    /**
     * @param ApplicationInterface $application
     *
     * @return void
     */
    public function updateApplication(ApplicationInterface $application)
    {
        $this->em->persist($application);
        $this->em->flush();
    }

    /**
     * @param UserInterface $sender
     * @param int           $page
     *
     * @return ApplicationInterface[]
     */
    public function findApplicationsBySender(UserInterface $sender, $page = 1)
    {
        $qb = $this->repository->createQueryBuilder('a')
            ->select('a,s,r,j')
            ->join('a.sender', 's')
            ->join('a.receiver', 'r')
            ->join('a.position', 'j')
            ->where('s.id = :sender')
            ->setParameter('sender', $sender->getId())
            ->orderBy('a.createdAt', 'DESC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page);

        return $pager;
    }

    /**
     * @param UserInterface     $sender
     * @param PositionInterface $position
     *
     * @return ApplicationInterface
     */
    public function findApplicationBySenderAndPosition(UserInterface $sender, PositionInterface $position)
    {
        $q = $this->repository->createQueryBuilder('a')
            ->select('a,s,r,j')
            ->join('a.sender', 's')
            ->join('a.receiver', 'r')
            ->join('a.position', 'j')
            ->where('s.id = :sender')
            ->andWhere('j.id = :position')
            ->setParameter('sender', $sender->getId())
            ->setParameter('position', $position->getId())
            ->getQuery();

        try {
            $application = $q->setMaxResults(1)->getSingleResult();
        } catch (NoResultException $e) {
            $application = null;
        }

        return $application;
    }

    /**
     * @param UserInterface $receiver
     * @param int           $page
     *
     * @return ApplicationInterface[]
     */
    public function findApplicationsByReceiver(UserInterface $receiver, $page = 1)
    {
        $qb = $this->repository->createQueryBuilder('a')
            ->select('a,s,r,j')
            ->join('a.sender', 's')
            ->join('a.receiver', 'r')
            ->join('a.position', 'j')
            ->where('r.id = :receiver')
            ->setParameter('receiver', $receiver->getId())
            ->orderBy('a.createdAt', 'DESC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page);

        return $pager;
    }

    /**
     * @param int $id
     *
     * @return ApplicationInterface
     */
    public function findApplicationById($id)
    {
        $q = $this->repository->createQueryBuilder('a')
            ->select('a,s,r,j')
            ->join('a.sender', 's')
            ->join('a.receiver', 'r')
            ->join('a.position', 'j')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            $application = $q->getSingleResult();
        } catch (NoResultException $e) {
            $application = null;
        }

        return $application;
    }

    public function getClass()
    {
        return $this->class;
    }
}