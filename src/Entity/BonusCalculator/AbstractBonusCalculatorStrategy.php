<?php

declare(strict_types=1);

namespace App\Entity\BonusCalculator;

use App\Entity\Employee;

abstract class AbstractBonusCalculatorStrategy implements BonusCalculatorStrategyInterface
{
    private Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function getEmployee(): Employee
    {
        return $this->employee;
    }
}
