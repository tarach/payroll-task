<?php

declare(strict_types=1);

namespace App\Entity\BonusCalculator;

class PercentageStrategy extends AbstractBonusCalculatorStrategy
{
    public function calculate(): int
    {
        $employee = $this->getEmployee();
        return (int) ($employee->getSalary() / $employee->getDepartment()->getBonusPercentage());
    }

    public function canCalculate(): bool
    {
        return !is_null($this->getEmployee()->getDepartment()->getBonusPercentage());
    }
}