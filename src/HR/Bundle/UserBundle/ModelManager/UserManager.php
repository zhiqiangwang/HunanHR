<?php
namespace HR\Bundle\UserBundle\ModelManager;

use HR\Bundle\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
abstract class UserManager implements UserManagerInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    protected $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function createUser()
    {
        $class = $this->getClass();
        $user  = new $class();

        return $user;
    }

    public function findUserByUsername($username)
    {
        return $this->findUserBy(array('username' => $username));
    }

    public function findUserByEmail($email)
    {
        return $this->findUserBy(array('email' => $email));
    }

    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    public function updatePassword(UserInterface $user)
    {
        if (null !== $password = $user->getPlainPassword()) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }
    }
}