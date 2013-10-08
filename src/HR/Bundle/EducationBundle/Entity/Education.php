<?php
namespace HR\Bundle\EducationBundle\Entity;

use HR\Bundle\EducationBundle\Model\Education as BaseEducation;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class Education extends BaseEducation
{
    public function getDegreeName()
    {
        $degrees = self::getDegrees();

        return $degrees[$this->degree];
    }

    public static function getDegrees()
    {
        return array(
            1 => '大专',
            2 => '本科',
            3 => '硕士',
            4 => '博士',
            5 => '其他'
        );
    }
}