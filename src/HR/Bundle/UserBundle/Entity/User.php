<?php
namespace HR\Bundle\UserBundle\Entity;

use HR\Bundle\EducationBundle\Entity\Education;
use HR\Bundle\UserBundle\Model\User as BaseUser;

/**
 * User Entity
 *
 * @author Wenming Tang <tang@babyfamily.com>
 */
class User extends BaseUser
{
    public function getGenderName()
    {
        $genders = static::getGenders();

        return $genders[$this->gender];
    }

    public function getDegreeName()
    {
        $degrees = Education::getDegrees();

        return $degrees[$this->degree];
    }

    public static function getGenders()
    {
        return array(
            'male'   => '男',
            'female' => '女'
        );
    }
}