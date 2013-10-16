<?php
namespace HR\UserBundle\Tests\Model;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\HR\UserBundle\ModelManager\UserManager
     */
    private $manager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $encoderFactory;

    protected function setUp()
    {
        $this->encoderFactory = $this->getMockEncoderFactory();

        $this->manager = $this->getMockBuilder('HR\UserBundle\ModelManager\UserManager')
            ->setConstructorArgs(array($this->encoderFactory))
            ->getMockForAbstractClass();
    }

    public function testUpdatePassword()
    {
        $encoder = $this->getMockPasswordEncoder();
        $user    = $this->getUser();

        $user->setPlainPassword('password');

        $this->encoderFactory->expects($this->once())
            ->method('getEncoder')
            ->will($this->returnValue($encoder));

        $encoder->expects($this->once())
            ->method('encodePassword')
            ->with('password', $user->getSalt())
            ->will($this->returnValue('encodedPassword'));

        $this->manager->updatePassword($user);

        $this->assertEquals('encodedPassword', $user->getPassword(), '->updatePassword() sets encoded password');
        $this->assertNull($user->getPlainPassword(), '->updatePassword() erases credentials');
    }

    public function testFindUserByUsername()
    {
        $this->manager->expects($this->once())
            ->method('findUserBy')
            ->with($this->equalTo(array('username' => 'twm')));

        $this->manager->findUserByUsername('twm');
    }

    public function testFindUserByEmail()
    {
        $this->manager->expects($this->once())
            ->method('findUserBy')
            ->with($this->equalTo(array('email' => 'twm@msn.cn')));

        $this->manager->findUserByEmail('twm@msn.cn');
    }

    private function getMockEncoderFactory()
    {
        return $this->getMock('Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface');
    }

    private function getMockPasswordEncoder()
    {
        return $this->getMock('Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\HR\UserBundle\Model\User
     */
    private function getUser()
    {
        return $this->getMockBuilder('HR\UserBundle\Model\User')->getMockForAbstractClass();
    }
}