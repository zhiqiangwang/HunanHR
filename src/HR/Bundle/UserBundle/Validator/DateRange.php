<?php
namespace HR\Bundle\UserBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class DateRange extends Constraint
{
    public $message = '请设置正确的起始时间';

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}