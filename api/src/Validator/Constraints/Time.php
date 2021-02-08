<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Time extends Constraint
{
    public $message = 'Start time can\'t be later than end time';
    
    public $message2 = 'Start time can\'t be earlier than open time and later than close time';
    
    public $message3 = 'End time can\'t be earlier than open time and later than close time';
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
