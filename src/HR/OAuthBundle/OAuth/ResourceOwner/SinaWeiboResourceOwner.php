<?php
namespace HR\OAuthBundle\OAuth\ResourceOwner;

use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\SinaWeiboResourceOwner as BaseSinaWeiboResourceOwner;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class SinaWeiboResourceOwner extends BaseSinaWeiboResourceOwner
{
    public function getUserInformation(array $accessToken = null, array $extraParameters = array())
    {
        $userResponse = parent::getUserInformation($accessToken, $extraParameters);

        $this->validateResponseContent($userResponse->getResponse());

        return $userResponse;
    }

    protected function validateResponseContent($response)
    {
        if (isset($response['error'])) {
            throw new AuthenticationException(sprintf('OAuth error: "%s"', $response['error']));
        }
    }
}