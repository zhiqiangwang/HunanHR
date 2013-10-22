<?php
namespace HR\PositionBundle\Acl;

use HR\PositionBundle\Model\PositionInterface;
use HR\PositionBundle\ModelManager\PositionManagerInterface;
use HR\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class AclPositionManager implements PositionManagerInterface
{
    /**
     * @var PositionManagerInterface
     */
    protected $realManager;

    /**
     * @var PositionAclInterface
     */
    protected $positionAcl;

    /**
     * @param PositionManagerInterface $realManager
     * @param PositionAclInterface     $acl
     */
    public function __construct(PositionManagerInterface $realManager, PositionAclInterface $acl)
    {
        $this->realManager = $realManager;
        $this->positionAcl = $acl;
    }

    /**
     * {@inheritDoc}
     */
    public function createPosition(UserInterface $user)
    {
        return $this->realManager->createPosition($user);
    }

    /**
     * {@inheritDoc}
     */
    public function findPositionById($id)
    {
        return $this->realManager->findPositionById($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findPositionByIds(array $idSet)
    {
        return $this->realManager->findPositionByIds($idSet);
    }

    /**
     * {@inheritDoc}
     */
    public function findAllPositions()
    {
        return $this->realManager->findAllPositions();
    }

    /**
     * {@inheritDoc}
     */
    public function findPositionsPagerByUser(UserInterface $user, $page = 1)
    {
        return $this->realManager->findPositionsPagerByUser($user, $page);
    }

    /**
     * {@inheritDoc}
     */
    public function findPositionsPagerByLatest($page = 1)
    {
        return $this->realManager->findPositionsPagerByUser($page);
    }

    /**
     * {@inheritDoc}
     */
    public function updatePosition(PositionInterface $position)
    {
        if (!$this->positionAcl->canCreate()) {
            throw new AccessDeniedException();
        }

        $newPosition = $this->isNewPosition($position);

        if (!$newPosition && !$this->positionAcl->canEdit($position)) {
            throw new AccessDeniedException();
        }

        $this->realManager->updatePosition($position);

        if ($newPosition) {
            $this->positionAcl->setDefaultAcl($position);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function softDeletePosition(PositionInterface $position)
    {
        if (!$this->positionAcl->canDelete($position)) {
            throw new AccessDeniedException();
        }

        $this->realManager->softDeletePosition($position);
    }

    /**
     * {@inheritDoc}
     */
    public function isNewPosition(PositionInterface $position)
    {
        return $this->realManager->isNewPosition($position);
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->realManager->getClass();
    }
}