<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HourMinute extends Constraint
{
    public $message = 'Hour has to be full or half past - it means end :00 or :30';
}
