<?php

declare(strict_types=1);

namespace App\Entity\BonusCalculator;

use App\Entity\Employee;

interface BonusCalculatorStrategyInterface
{
    public function __construct(Employee $employee);
    public function calculate(): int;
    public function canCalculate(): bool;
}