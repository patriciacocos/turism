<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HotelReservationDateRange extends Constraint
{
    public $message= 'Data sosire trebuie sa fie mai mica decat data plecare';

    public function getTargets()
    {
        return [
            self::CLASS_CONSTRAINT
        ];
    }
}
