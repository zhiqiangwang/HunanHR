<?php
namespace HR\Bundle\PositionBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use HR\Bundle\PositionBundle\Model\PositionInterface;
use HR\Bundle\UserBundle\Model\UserInterface;
use HR\Bundle\PositionBundle\ModelManager\PositionManager as BasePositionManager;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

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

    /**
     * {@inheritdoc}
     */
    public function findPositionsByUser(UserInterface $user)
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
    public function findPositionById($positionId)
    {
        return $this->repository->findOneBy(array('id' => $positionId));
    }

    /**
     * {@inheritdoc}
     */
    public function deletePosition(PositionInterface $position)
    {
        $this->em->remove($position);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function doUpdatePosition(PositionInterface $position)
    {
        $this->em->persist($position);
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