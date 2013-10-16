<?php
namespace HR\SkillBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use HR\SkillBundle\Model\SkillInterface;
use HR\SkillBundle\ModelManager\SkillManager as BaseSkillManager;
use HR\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class SkillManager extends BaseSkillManager
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
    public function findSkillById($id)
    {
        return $this->repository->findOneBy(array('id' => $id));
    }

    /**
     * @param UserInterface $user
     *
     * @return array of skill
     */
    public function findSkillsByUser(UserInterface $user)
    {
        $q = $this->repository->createQueryBuilder('s')
            ->select('s, u')
            ->join('s.user', 'u')
            ->where('u.id = :user')
            ->addOrderBy('s.createdAt', 'DESC')
            ->setParameter('user', $user->getId())
            ->getQuery();

        return $q->getResult();
    }


    protected function doUpdateSkill(SkillInterface $skill)
    {
        $this->em->persist($skill);
        $this->em->flush();
    }

    /**
     * @param SkillInterface $skill
     *
     * @return void
     */
    public function deleteSkill(SkillInterface $skill)
    {
        $this->em->remove($skill);
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