<?php
namespace HR\PositionBundle\EventListener;

use Elastica\Document;
use Elastica\Type;
use HR\PositionBundle\Event\PositionEvent;
use HR\PositionBundle\PositionEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PositionIndexesListener implements EventSubscriberInterface
{
    /**
     * @var Type
     */
    private $positionType;

    function __construct(Type $positionType)
    {
        $this->positionType = $positionType;
    }

    public function onPositionEditCompleted(PositionEvent $event)
    {
        $position = $event->getPosition();

        $document = new Document();
        $document
            ->setId($position->getId())
            ->setData(array(
                'position'    => $position->getPosition(),
                'description' => $position->getDescription(),
                'companyName' => $position->getCompanyName(),
                'city'        => $position->getCity()->getName(),
                'location'    => $position->getLocation()
            ));

        $this->positionType->updateDocument($document);
    }

    public function onPositionDeleteCompleted(PositionEvent $event)
    {
        $position = $event->getPosition();

        $this->positionType->deleteById($position->getId());
    }

    public static function getSubscribedEvents()
    {
        return array(
            PositionEvents::POSITION_EDIT_COMPLETED   => 'onPositionEditCompleted',
            PositionEvents::POSITION_DELETE_COMPLETED => 'onPositionDeleteCompleted'
        );
    }
}