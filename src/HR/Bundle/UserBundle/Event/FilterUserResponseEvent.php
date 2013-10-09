<?php
namespace HR\Bundle\UserBundle\Event;

use HR\Bundle\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class FilterUserResponseEvent extends UserEvent
{
    private $response;

    public function __construct(UserInterface $user, Request $request, Response $response)
    {
        parent::__construct($user, $request);
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}