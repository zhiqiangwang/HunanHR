<?php
namespace HR\OAuthBundle\OAuth\Response;

use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class WeiboUserResponse extends PathUserResponse
{
    public function getGender()
    {
        return $this->getValueForPath('gender') == 'm' ? 'male': 'female';
    }

    public function getDomain()
    {
        return $this->getValueForPath('domain');
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
        return $this->getValueForPath('homepage');
    }

    public function getBio()
    {
        return $this->getValueForPath('bio');
    }
}