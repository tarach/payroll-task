<?php

declare(strict_types=1);

namespace App\Entity\BonusCalculator;

class ConstantStrategy extends AbstractBonusCalculatorStrategy
{
    public function calculate(): int
    {
        $employee = $this->getEmployee();
        $bonus = $employee->getDepartment()->getBonusConstant();
        $years = $employee->getYearsWorked();
        $multiplier = $years > 10 ? 10 : $years;

        return $bonus * $multiplier;
    }

    public function canCalculate(): bool
    {
        return !is_null($this->getEmployee()->getDepartment()->getBonusConstant());
    }
}