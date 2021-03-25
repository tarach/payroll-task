<?php

declare(strict_types=1);

namespace App\Entity\BonusCalculator;

use App\Entity\Employee;

class BonusCalculator
{
    private array $strategy = [
        Employee::BONUS_TYPE_PERCENTAGE => PercentageStrategy::class,
        Employee::BONUS_TYPE_CONSTANT => ConstantStrategy::class,
    ];

    public function calculate(Employee $employee): ?int
    {
        $strategy = $this->chooseStrategy($employee);
        if ($strategy->canCalculate()) {
            return $strategy->calculate();
        }
        return null;
    }

    private function chooseStrategy(Employee $employee): BonusCalculatorStrategyInterface
    {
        $bonusType = $employee->getBonusType();

        if (!array_key_exists($bonusType, $this->strategy)) {
            throw new \LogicException(sprintf('Unsupported bonus type [%s].', $bonusType));
        }

        return new $this->strategy[$bonusType]($employee);
    }
}
