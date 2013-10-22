<?php
namespace HR\PositionBundle\Twig\Extension;

use HR\PositionBundle\Acl\PositionAclInterface;
use HR\PositionBundle\Model\PositionInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PositionAclExtension extends \Twig_Extension
{
    /**
     * @var PositionAclInterface
     */
    protected $positionAcl;

    /**
     * @param PositionAclInterface $positionAcl
     */
    public function __construct(PositionAclInterface $positionAcl)
    {
        $this->positionAcl = $positionAcl;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'can_create_position' => new \Twig_Function_Method($this, 'canCreate'),
            'can_view_position'   => new \Twig_Function_Method($this, 'canView'),
            'can_edit_position'   => new \Twig_Function_Method($this, 'canEdit'),
            'can_delete_position' => new \Twig_Function_Method($this, 'canDelete'),
        );
    }

    /**
     * @return boolean
     */
    public function canCreate()
    {
        return $this->positionAcl->canCreate();
    }

    /**
     * @param PositionInterface $position
     *
     * @return boolean
     */
    public function canView(PositionInterface $position)
    {
        return $this->positionAcl->canView($position);
    }

    /**
     * @param PositionInterface $position
     *
     * @return boolean
     */
    public function canEdit(PositionInterface $position)
    {
        return $this->positionAcl->canEdit($position);
    }

    /**
     * @param PositionInterface $position
     *
     * @return boolean
     */
    public function canDelete(PositionInterface $position)
    {
        return $this->positionAcl->canDelete($position);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ghost.position_acl';
    }
}