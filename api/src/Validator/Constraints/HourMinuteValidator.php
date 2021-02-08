<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
final class HourMinuteValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($value->getTimestamp());
            
        $minutes = $dateTime->format('i');
        
        if ($minutes !== '00' && $minutes !== '30') {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
