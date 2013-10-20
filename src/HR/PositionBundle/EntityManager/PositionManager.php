<?php
namespace HR\PositionBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use HR\PositionBundle\Model\PositionInterface;
use HR\PositionBundle\ModelManager\PositionManager as BasePositionManager;
use HR\UserBundle\Model\UserInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PositionManager extends BasePositionManager
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

    public function findPositionsPagerByUser(UserInterface $user, $page = 1)
    {
        $qb = $this->repository->createQueryBuilder('j')
            ->select('j, u, c')
            ->join('j.user', 'u')
            ->join('j.city', 'c')
            ->where('u.id = :user')
            ->andWhere('j.isDeleted = false')
            ->addOrderBy('j.createdAt', 'DESC')
            ->setParameter('user', $user->getId());

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page);

        return $pager;
    }

    public function findPositionsPagerByLatest($page = 1)
    {
        $qb = $this->repository->createQueryBuilder('j')
            ->select('j, u, c')
            ->join('j.user', 'u')
            ->join('j.city', 'c')
            ->andWhere('j.isDeleted = false')
            ->addOrderBy('j.createdAt', 'DESC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page);

        return $pager;
    }

    public function findPositionByIds(array $idSet)
    {
        $qb = $this->repository->createQueryBuilder('j');
        $qb
            ->select('j, u, c')
            ->join('j.user', 'u')
            ->join('j.city', 'c')
            ->where($qb->expr()->in('j.id', $idSet))
            ->andWhere('j.isDeleted = false')
            ->addOrderBy('j.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }


    public function findPositionById($id)
    {
        $q = $this->repository->createQueryBuilder('j')
            ->select('j, u, c')
            ->join('j.user', 'u')
            ->join('j.city', 'c')
            ->where('j.id = :id')
            ->andWhere('j.isDeleted = false')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            $position = $q->getSingleResult();
        } catch (NoResultException $e) {
            $position = null;
        }

        return $position;
    }

    public function findAllPositions()
    {
        return $this->repository->findAll();
    }

    protected function doUpdateEducation($position)
    {
        $this->em->persist($position);
        $this->em->flush();
    }

    public function softDeletePosition(PositionInterface $position)
    {
        $position->setIsDeleted(true);

        $this->em->persist($position);
        $this->em->flush();
    }

    public function isNewPosition(PositionInterface $position)
    {
        return !$this->em->getUnitOfWork()->isInIdentityMap($position);
    }

    public function getClass()
    {
        return $this->class;
    }
}