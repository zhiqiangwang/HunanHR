<?php
namespace HR\Bundle\UserBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use HR\Bundle\UserBundle\Model\GroupInterface;
use HR\Bundle\UserBundle\ModelManager\GroupManager as BaseGroupManager;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class GroupManager extends BaseGroupManager
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
    public function deleteGroup(GroupInterface $group)
    {
        $this->em->remove($group);
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function findGroupBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findGroups()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function updateGroup(GroupInterface $group)
    {
        $this->em->persist($group);
        $this->em->flush();
    }
}