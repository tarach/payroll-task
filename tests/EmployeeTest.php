<?php

namespace App\Tests;

use App\Entity\Employee;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    public function testEmployeeShouldWorkCorrectNumberOfYears(): void
    {
        $employee = new Employee();
        $employee->setHiredAt(new \DateTime('2015-01-01'));

        $this->assertEquals(5, $employee->getYearsWorked('2020-01-01'));
    }
}
