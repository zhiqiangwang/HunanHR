<?php
namespace HR\UserBundle\Security;

use HR\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface LoginManagerInterface
{
    public function loginUser($firewallName, UserInterface $user, Response $response = null);
}