<?php
namespace HR\Bundle\UserBundle\Event;

use HR\Bundle\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class UserEvent extends Event
{
    private $user;
    private $request;

    public function __construct(UserInterface $user, Request $request)
    {
        $this->user    = $user;
        $this->request = $request;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getRequest()
    {
        return $this->request;
    }
}