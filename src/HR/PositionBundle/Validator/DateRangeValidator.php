<?php
namespace HR\PositionBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class DateRangeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (null === $value->getStartDate() && null === $value->getEndDate()) {
            return;
        }

        if (null === $value->getStartDate() || null == $value->getEndDate() ||
            $value->getStartDate() > $value->getEndDate()) {
            $this->context->addViolationAt('endDate', $constraint->message);
        }
    }
}