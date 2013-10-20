<?php
namespace HR\PositionBundle\Acl;
use HR\PositionBundle\Model\PositionInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface PositionAclInterface
{
    public function canCreate();

    public function canView(PositionInterface $position);

    public function canEdit(PositionInterface $position);

    public function canDelete(PositionInterface $position);

    public function setDefaultAcl(PositionInterface $topic);

    public function installFallbackAcl();

    public function uninstallFallBackAcl();
}