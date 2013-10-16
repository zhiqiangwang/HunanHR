<?php
namespace HR\UserBundle\Tests\Model;
use HR\UserBundle\Model\User;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testUsername()
    {
        $user = $this->getUser();
        $this->assertNull($user->getUsername());

        $user->setUsername('twm');
        $this->assertEquals('twm', $user->getUsername());
    }

    public function testEmail()
    {
        $user = $this->getUser();
        $this->assertNull($user->getEmail());

        $user->setEmail('twm@msn.cn');
        $this->assertEquals('twm@msn.cn', $user->getEmail());
    }

    public function testTrueHasRole()
    {
        $user = $this->getUser();
        $this->assertTrue($user->hasRole(User::ROLE_DEFAULT));

        $user->addRole(User::ROLE_DEFAULT);
        $this->assertTrue($user->hasRole(User::ROLE_DEFAULT));

        $user->addRole('ROLE_NEW');
        $this->assertTrue($user->hasRole('ROLE_NEW'));
    }

    public function testFalseHasRole()
    {
        $user = $this->getUser();
        $this->assertFalse($user->hasRole(User::ROLE_SUPER_ADMIN));

        $user->addRole(User::ROLE_SUPER_ADMIN);
        $this->assertTrue($user->hasRole(User::ROLE_SUPER_ADMIN));
    }

    public function testExpiresAt()
    {
        $user = $this->getUser();
        $this->assertTrue($user->isAccountNonExpired());

        $user->setExpiresAt(new \Datetime('+10 seconds'));
        $this->assertTrue($user->isAccountNonExpired());

        $user->setExpiresAt(new \Datetime('-10 seconds'));
        $this->assertFalse($user->isAccountNonExpired());

        $user->setExpired(true);
        $this->assertFalse($user->isAccountNonExpired());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\HR\UserBundle\Model\User
     */
    private function getUser()
    {
        return $this->getMockBuilder('HR\UserBundle\Model\User')->getMockForAbstractClass();
    }
}