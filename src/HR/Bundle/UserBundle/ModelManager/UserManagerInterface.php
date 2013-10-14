<?php
namespace HR\Bundle\UserBundle\ModelManager;

use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface UserManagerInterface
{
    /**
     * @return UserInterface
     */
    public function createUser();

    /**
     * @param UserInterface $user
     *
     * @return void
     */
    public function updateUser(UserInterface $user);

    /**
     * @return array of UserInterface
     */
    public function findUsers();

    /**
     * @param array $criteria
     *
     * @return UserInterface
     */
    public function findUserBy(array $criteria);

    /**
     * @param string $username
     *
     * @return UserInterface
     */
    public function findUserByUsername($username);

    /**
     * @param string $email
     *
     * @return UserInterface
     */
    public function findUserByEmail($email);

    /**
     * @param string $usernameOrEmail
     *
     * @return UserInterface
     */
    public function findUserByUsernameOrEmail($usernameOrEmail);

    /**
     * @param string $confirmationToken
     *
     * @return UserInterface
     */
    public function findUserByConfirmationToken($confirmationToken);

    /**
     * @param UserInterface $user
     *
     * @return void
     */
    public function updatePassword(UserInterface $user);

    /**
     * @return string
     */
    public function getClass();
}