<?php
namespace HR\Bundle\UserBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use HR\Bundle\UserBundle\Model\UserInterface;
use HR\Bundle\UserBundle\ModelManager\UserManager as BaseUserManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class UserManager extends BaseUserManager
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

    public function __construct(EncoderFactoryInterface $encoderFactory, EntityManager $em, $class)
    {
        parent::__construct($encoderFactory);

        $this->em         = $em;
        $this->repository = $this->em->getRepository($class);
        $this->class      = $this->em->getClassMetadata($class)->getName();
    }

    public function findUserBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findUsers()
    {
        return $this->repository->findAll();
    }

    public function updateUser(UserInterface $user)
    {
        $this->updatePassword($user);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function getClass()
    {
        return $this->class;
    }
}