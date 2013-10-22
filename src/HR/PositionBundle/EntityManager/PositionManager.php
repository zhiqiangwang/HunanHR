<?php
namespace HR\PositionBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use HR\PositionBundle\Model\PositionInterface;
use HR\PositionBundle\ModelManager\PositionManager as BasePositionManager;
use HR\UserBundle\Model\UserInterface;

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

    /** @var \Knp\Component\Pager\Paginator */
    protected $paginator;

    public function __construct(EntityManager $em, $class, $paginator)
    {
        $this->em         = $em;
        $this->repository = $this->em->getRepository($class);
        $this->class      = $this->em->getClassMetadata($class)->getName();
        $this->paginator  = $paginator;
    }

    public function findPositionsPagerByUser(UserInterface $user, $page = 1)
    {
        $qb = $this->repository->createQueryBuilder('p')
            ->select('p, u')
            ->join('p.user', 'u')
            ->where('u.id = :user')
            ->andWhere('p.isDeleted = false')
            ->addOrderBy('p.createdAt', 'DESC')
            ->setParameter('user', $user->getId());

        return $this->paginator->paginate($qb, $page);
    }

    public function findPositionsPagerByLatest($page = 1)
    {
        $qb = $this->repository->createQueryBuilder('p')
            ->select('p, u')
            ->join('p.user', 'u')
            ->andWhere('p.isDeleted = false')
            ->addOrderBy('p.createdAt', 'DESC');

        return $this->paginator->paginate($qb, $page);
    }

    public function findPositionByIds(array $idSet)
    {
        $qb = $this->repository->createQueryBuilder('j');
        $qb
            ->select('j, u')
            ->join('p.user', 'u')
            ->where($qb->expr()->in('p.id', $idSet))
            ->andWhere('p.isDeleted = false')
            ->addOrderBy('p.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }


    public function findPositionById($id)
    {
        $q = $this->repository->createQueryBuilder('p')
            ->select('p, u')
            ->join('p.user', 'u')
            ->where('p.id = :id')
            ->andWhere('p.isDeleted = false')
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
        $position->setDeletedAt(new \Datetime());

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