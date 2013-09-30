<?php
namespace HR\Bundle\UserBundle\ModelManager;

use HR\Bundle\UserBundle\Model\UserInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
interface UserManagerInterface
{
    public function createUser();

    public function updateUser(UserInterface $user);

    public function findUsers();

    public function findUserBy(array $criteria);

    public function findUserByUsername($username);

    public function findUserByEmail($email);

    public function findUserByUsernameOrEmail($usernameOrEmail);

    public function updatePassword(UserInterface $user);

    public function getClass();
}