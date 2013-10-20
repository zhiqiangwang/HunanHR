<?php
namespace HR\PositionBundle\Event;
use HR\PositionBundle\Model\PositionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PositionEvent extends Event
{
    private $position;

    public function __construct(PositionInterface $position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }
}