<?php
namespace HR\UserBundle\Security;

use HR\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\RememberMe\RememberMeServicesInterface;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class LoginManager implements LoginManagerInterface
{
    private $securityContext;
    private $userChecker;
    private $sessionStrategy;
    private $container;

    public function __construct(SecurityContextInterface $context, UserCheckerInterface $userChecker,
                                SessionAuthenticationStrategyInterface $sessionStrategy,
                                ContainerInterface $container)
    {
        $this->securityContext = $context;
        $this->userChecker     = $userChecker;
        $this->sessionStrategy = $sessionStrategy;
        $this->container       = $container;
    }

    final public function loginUser($firewallName, UserInterface $user, Response $response = null)
    {
        $this->userChecker->checkPostAuth($user);

        $token = $this->createToken($firewallName, $user);

        if ($this->container->isScopeActive('request')) {
            $this->sessionStrategy->onAuthentication($this->container->get('request'), $token);

            if (null !== $response) {
                $rememberMeServices = null;
                if ($this->container->has('user.security.authentication.rememberme.services.simplehash.' . $firewallName)) {
                    $rememberMeServices = $this->container->get('user.security.authentication.rememberme.services.simplehash.' . $firewallName);
                }

                if ($rememberMeServices instanceof RememberMeServicesInterface) {
                    $rememberMeServices->loginSuccess($this->container->get('request'), $response, $token);
                }
            }
        }

        $this->securityContext->setToken($token);
    }

    protected function createToken($firewall, UserInterface $user)
    {
        return new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
    }
}