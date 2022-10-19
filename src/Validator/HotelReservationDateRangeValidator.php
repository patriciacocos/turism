<?php

namespace App\Validator;

use App\Entity\RezervareCazare;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class HotelReservationDateRangeValidator extends ConstraintValidator
{

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$value instanceof RezervareCazare)
        {
            throw new UnexpectedTypeException($constraint, RezervareCazare::class);
        }
        if($value->getDataSosire() >= $value->getDataPlecare())
        {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
