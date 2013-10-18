<?php
namespace HR\OAuthBundle\Security;

use HR\OAuthBundle\ModelManager\ConnectManagerInterface;
use HR\UserBundle\ModelManager\UserManagerInterface;
use HR\UserBundle\Security\UserProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class OAuthUserProvider extends UserProvider implements AccountConnectorInterface, OAuthAwareUserProviderInterface
{
    /**
     * @var ConnectManagerInterface
     */
    protected $connectManager;

    /**
     * @var array
     */
    protected $properties;

    function __construct(UserManagerInterface $userManager, ConnectManagerInterface $connectManager)
    {
        parent::__construct($userManager);

        $this->connectManager = $connectManager;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $username          = $response->getUsername();
        $resourceOwnerName = $response->getResourceOwner()->getName();

        $previousConnect = $this->connectManager->findConnectBy(array(
            'provider'       => $resourceOwnerName,
            'identification' => $username
        ));

        if (null !== $previousConnect) {
            $previousConnect->setAccessToken($response->getAccessToken());
            $previousConnect->setExpiresAt($this->getExpiresAt($response));

            $this->connectManager->updateConnect($previousConnect);
        } else {
            $connect = $this->connectManager->createConnect($user);
            $connect->setProvider($resourceOwnerName);
            $connect->setIdentification($username);
            $connect->setAccessToken($response->getAccessToken());
            $connect->setExpiresAt($this->getExpiresAt($response));

            $this->userManager->updateUser($user);
            $this->connectManager->updateConnect($connect);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username          = $response->getUsername();
        $resourceOwnerName = $response->getResourceOwner()->getName();

        $connect = $this->connectManager->findConnectBy(array(
            'provider'       => $resourceOwnerName,
            'identification' => $username
        ));

        if (null === $connect) {
            throw new AccountNotLinkedException(sprintf("User '%s' not found.", $username));
        }

        $connect->setAccessToken($response->getAccessToken());
        $connect->setExpiresAt($this->getExpiresAt($response));

        $this->connectManager->updateConnect($connect);

        return $connect->getUser();
    }

    protected function getExpiresAt(UserResponseInterface $response)
    {
        $expiresAt = new \Datetime();
        $expiresAt->setTimestamp(time() + $response->getExpiresIn());

        return $expiresAt;
    }
}