<?php
namespace HR\OAuthBundle\EntityManager;

use Doctrine\ORM\EntityManager;

use HR\OAuthBundle\Model\ConnectInterface;
use HR\OAuthBundle\ModelManager\ConnectManager as BaseConnectManager;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ConnectManager extends BaseConnectManager
{
    protected $em;
    protected $class;
    protected $repository;

    public function __construct(EntityManager $em, $class)
    {
        $this->em         = $em;
        $this->repository = $this->em->getRepository($class);
        $this->class      = $this->em->getClassMetadata($class)->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function findConnectBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function updateConnect(ConnectInterface $connect)
    {
        $this->em->persist($connect);
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteConnect(ConnectInterface $connect)
    {
        $this->em->remove($connect);
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}