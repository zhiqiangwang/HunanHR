<?php
namespace HR\OAuthBundle\OAuth\Response;

use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class QQUserResponse extends PathUserResponse
{
    public function getGender()
    {
        return $this->getValueForPath('gender') == '男' ? 'male': 'female';
    }

    public function getScreenName()
    {
        return null;
    }

    public function getAvatarBigUrl()
    {
        return $this->getValueForPath('avatarbigurl');
    }

    public function getAvatarSmallUrl()
    {
        return $this->getValueForPath('avatarsmallurl');
    }

    public function getHomepage()
    {
        return null;
    }

    public function getBio()
    {
        return null;
    }
}