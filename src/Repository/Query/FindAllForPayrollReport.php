<?php

declare(strict_types=1);

namespace App\Repository\Query;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\QueryBuilder;

class FindAllForPayrollReport
{
    private ?string $sortColumn;
    private string $sortOrder = 'ASC';
    private ?string $filterFirstName;
    private ?string $filterLastName;
    private ?string $filterDepartment;

    private QueryBuilder $query;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->query = $employeeRepository->createQueryBuilder('e')
            ->leftJoin('e.department', 'd')
        ;
    }

    public function __invoke()
    {
        if ($this->sortColumn) {
            $this->query->orderBy($this->sortColumn, $this->sortOrder);
        }

        $filters = [
            'e.firstName' => $this->filterFirstName,
            'e.lastName' => $this->filterLastName,
            'd.name' => $this->filterDepartment,
        ];

        foreach ($filters as $field => $value) {
            if (!$value) {
                continue;
            }
            $paramName = str_replace('.', '', $field);
            $this->query->andWhere(sprintf('%s = :%s', $field, $paramName));
            $this->query->setParameter(':' . $paramName, $value);
        }

        return $this->query->getQuery()->getResult();
    }

    public function setSortColumn(?string $sortColumn): void
    {
        $this->sortColumn = $sortColumn;
    }

    public function setSortOrder(string $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }

    public function setFilterFirstName(?string $filterFirstName): void
    {
        $this->filterFirstName = $filterFirstName;
    }

    public function setFilterLastName(?string $filterLastName): void
    {
        $this->filterLastName = $filterLastName;
    }

    public function setFilterDepartment(?string $filterDepartment): void
    {
        $this->filterDepartment = $filterDepartment;
    }
}