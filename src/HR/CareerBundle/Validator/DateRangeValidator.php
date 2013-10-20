<?php
namespace HR\CareerBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

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
            $value->getStartDate() > $value->getEndDate()
        ) {
            $this->context->addViolationAt('endDate', $constraint->message);
        }
    }
}