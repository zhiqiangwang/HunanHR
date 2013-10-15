<?php
namespace HR\Bundle\JobBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use HR\Bundle\JobBundle\Model\DeliveryInterface;
use HR\Bundle\JobBundle\Model\JobInterface;
use  HR\Bundle\JobBundle\ModelManager\DeliveryManager as BaseDeliveryManager;
use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class DeliveryManager extends BaseDeliveryManager
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
     * @param DeliveryInterface $delivery
     *
     * @return void
     */
    public function updateDelivery(DeliveryInterface $delivery)
    {
        $this->em->persist($delivery);
        $this->em->flush();
    }

    /**
     * @param UserInterface $sender
     *
     * @return DeliveryInterface[]
     */
    public function findDeliveriesBySender(UserInterface $sender)
    {
        $q = $this->repository->createQueryBuilder('a')
            ->select('a,s,r,j')
            ->join('a.sender', 's')
            ->join('a.receiver', 'r')
            ->join('a.job', 'j')
            ->where('s.id = :sender')
            ->setParameter('sender', $sender->getId())
            ->getQuery();

        return $q->getResult();
    }

    /**
     * @param UserInterface $sender
     * @param JobInterface  $job
     *
     * @return DeliveryInterface
     */
    public function findDeliveryBySenderAndJob(UserInterface $sender, JobInterface $job)
    {
        $q = $this->repository->createQueryBuilder('a')
            ->select('a,s,r,j')
            ->join('a.sender', 's')
            ->join('a.receiver', 'r')
            ->join('a.job', 'j')
            ->where('s.id = :sender')
            ->andWhere('j.id = :job')
            ->setParameter('sender', $sender->getId())
            ->setParameter('job', $job->getId())
            ->getQuery();

        try {
            $delivery = $q->setMaxResults(1)->getSingleResult();
        } catch (NoResultException $e) {
            $delivery = null;
        }

        return $delivery;
    }

    /**
     * @param UserInterface $receiver
     *
     * @return DeliveryInterface[]
     */
    public function findDeliveriesByReceiver(UserInterface $receiver)
    {
        $q = $this->repository->createQueryBuilder('a')
            ->select('a,s,r,j')
            ->join('a.sender', 's')
            ->join('a.receiver', 'r')
            ->join('a.job', 'j')
            ->where('r.id = :receiver')
            ->setParameter('receiver', $receiver->getId())
            ->getQuery();

        return $q->getResult();
    }

    /**
     * @param int $id
     *
     * @return DeliveryInterface
     */
    public function findDeliveryById($id)
    {
        $q = $this->repository->createQueryBuilder('a')
            ->select('a,s,r,j')
            ->join('a.sender', 's')
            ->join('a.receiver', 'r')
            ->join('a.job', 'j')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            $delivery = $q->getSingleResult();
        } catch (NoResultException $e) {
            $delivery = null;
        }

        return $delivery;
    }

    public function getClass()
    {
        return $this->class;
    }
}