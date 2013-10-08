<?php
namespace HR\Bundle\UserBundle\Entity;

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

    public static function getGenders()
    {
        return array(
            'male'   => '男',
            'female' => '女'
        );
    }
}