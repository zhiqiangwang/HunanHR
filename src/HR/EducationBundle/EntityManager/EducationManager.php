<?php
namespace HR\EducationBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use HR\EducationBundle\Model\EducationInterface;
use HR\EducationBundle\ModelManager\EducationManager as BaseEducationManager;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class EducationManager extends BaseEducationManager
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
     * @param int $id
     *
     * @return $this
     */
    public function findEducationById($id)
    {
        return $this->repository->findOneBy(array('id' => $id));
    }

    /**
     * @param UserInterface $user
     *
     * @return array of education
     */
    public function findEducationsByUser(UserInterface $user)
    {
        $q = $this->repository->createQueryBuilder('e')
            ->select('e, u')
            ->join('e.user', 'u')
            ->where('u.id = :user')
            ->addOrderBy('e.endDate', 'DESC')
            ->setParameter('user', $user->getId())
            ->getQuery();

        return $q->getResult();
    }


    protected function doUpdateEducation(EducationInterface $education)
    {
        $this->em->persist($education);
        $this->em->flush();
    }

    /**
     * @param EducationInterface $education
     *
     * @return void
     */
    public function deleteEducation(EducationInterface $education)
    {
        $this->em->remove($education);
        $this->em->flush();
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}