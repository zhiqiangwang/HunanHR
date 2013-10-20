<?php
namespace HR\CareerBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use HR\CareerBundle\Model\CareerInterface;
use HR\CareerBundle\ModelManager\CareerManager as BaseCareerManager;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class CareerManager extends BaseCareerManager
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
     * {@inheritdoc}
     */
    public function findCareersByUser(UserInterface $user)
    {
        $q = $this->repository->createQueryBuilder('p')
            ->select('p, u')
            ->join('p.user', 'u')
            ->where('u.id = :user')
            ->addOrderBy('p.endDate', 'DESC')
            ->setParameter('user', $user->getId())
            ->getQuery();

        return $q->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findCareerById($careerId)
    {
        return $this->repository->findOneBy(array('id' => $careerId));
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCareer(CareerInterface $career)
    {
        $this->em->remove($career);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function doUpdateCareer(CareerInterface $career)
    {
        $this->em->persist($career);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}