<?php
namespace HR\PositionBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class DateRange extends Constraint
{
    public $message = '请设置正确的起止时间';

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}