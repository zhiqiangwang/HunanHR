<?php
namespace HR\JobBundle\Entity;

use HR\JobBundle\Model\Job as BaseJob;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class Job extends BaseJob
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