<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
final class TimeValidator extends ConstraintValidator
{  
    public function validate($reservation, Constraint $constraint): void
    {
        $openTime = strtotime($_ENV['TIME_OPEN']);
        $closeTime = strtotime($_ENV['TIME_CLOSE']);
        
        $dateStart = new \DateTime();
        $dateStart->setTimestamp($reservation->getTimeStart()->getTimestamp());
        
        $dateEnd = new \DateTime();
        $dateEnd->setTimestamp($reservation->getTimeEnd()->getTimestamp());
        
        $timeStart = strtotime($dateStart->format('H:i'));
        $timeEnd = strtotime($dateEnd->format('H:i'));
        
        if ($timeStart >= $timeEnd) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
        
        if ($timeStart < $openTime || $timeStart > $closeTime) {
            $this->context->buildViolation($constraint->message2)->addViolation();  
        }
        
        if ($timeEnd < $openTime || $timeEnd > $closeTime) {
            $this->context->buildViolation($constraint->message3)->addViolation();  
        }
    }
}
