<?php
namespace HR\JobBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use HR\JobBundle\Model\JobInterface;
use  HR\JobBundle\ModelManager\JobManager as BaseJobManager;
use HR\JobBundle\Pagination\Pager;
use HR\JobBundle\Pagination\ProxyQuery;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class JobManager extends BaseJobManager
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

    public function findJobsPagerByUser(UserInterface $user, $page = 1)
    {
        $qb = $this->repository->createQueryBuilder('j')
            ->select('j, u, c')
            ->join('j.user', 'u')
            ->join('j.city', 'c')
            ->where('u.id = :user')
            ->andWhere('j.isDeleted = false')
            ->addOrderBy('j.createdAt', 'DESC')
            ->setParameter('user', $user->getId());

        $pager = new Pager(new ProxyQuery($qb));
        $pager->setPage($page);

        return $pager;
    }

    public function findJobsPagerByLatest($page = 1)
    {
        $qb = $this->repository->createQueryBuilder('j')
            ->select('j, u, c')
            ->join('j.user', 'u')
            ->join('j.city', 'c')
            ->andWhere('j.isDeleted = false')
            ->addOrderBy('j.createdAt', 'DESC');

        $pager = new Pager(new ProxyQuery($qb));
        $pager->setPage($page);

        return $pager;
    }

    public function findJobById($id)
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
            $job = $q->getSingleResult();
        } catch (NoResultException $e) {
            $job = null;
        }

        return $job;
    }

    public function findAllJobs()
    {
        return $this->repository->findAll();
    }

    protected function doUpdateEducation($job)
    {
        $this->em->persist($job);
        $this->em->flush();
    }

    public function softDeleteJob(JobInterface $job)
    {
        $job->setIsDeleted(true);

        $this->em->persist($job);
        $this->em->flush();
    }

    public function isNewJob(JobInterface $job)
    {
        return !$this->em->getUnitOfWork()->isInIdentityMap($job);
    }

    public function getClass()
    {
        return $this->class;
    }
}