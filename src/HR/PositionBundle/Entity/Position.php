<?php
namespace HR\PositionBundle\Entity;

use HR\PositionBundle\Model\Position as BasePosition;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 *
 */
class Position extends BasePosition
{
    public function getTypeName()
    {
        $degrees = self::getTypes();

        return $degrees[$this->type];
    }

    public static function getTypes()
    {
        return array(
            1 => '全职',
            2 => '兼职',
            3 => '临时',
            4 => '实习'
        );
    }
}