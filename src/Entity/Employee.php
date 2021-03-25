<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\BonusCalculator\BonusCalculator;
use App\Repository\EmployeeRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Employee
{
    const BONUS_TYPE_PERCENTAGE = 1;
    const BONUS_TYPE_CONSTANT = 2;

    private array $bonusTypeDictionary = [
        self::BONUS_TYPE_PERCENTAGE => 'Percentage',
        self::BONUS_TYPE_CONSTANT => 'Constant',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="integer")
     */
    private int $salary;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $bonusType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $salaryWithBonus;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $hiredAt;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Department $department;

    /**
     * @ORM\PrePersist()
     */
    public function calculateSalaryWithBonus(): void
    {
        // Note: Should only be calculated when related data changes
        $bonus = (new BonusCalculator())->calculate($this);

        if ($bonus) {
            $this->salaryWithBonus = $this->salary + $bonus;
        }
    }

    public function getYearsWorked(string $current = 'now'): int
    {
        return (new \DateTime($current))->diff($this->hiredAt)->y;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @Groups("report")
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @Groups("report")
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @Groups("report")
     */
    public function getSalary(): int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getBonusType(): int
    {
        return $this->bonusType;
    }

    /**
     * @Groups("report")
     */
    public function getBonus(): int
    {
        return $this->salaryWithBonus - $this->salary;
    }

    /**
     * @Groups("report")
     */
    public function getBonusTypeName(): string
    {
        return $this->bonusTypeDictionary[$this->bonusType];
    }

    public function setBonusType(int $bonusType): self
    {
        $this->bonusType = $bonusType;

        return $this;
    }

    /**
     * @Groups("report")
     */
    public function getSalaryWithBonus(): ?int
    {
        return $this->salaryWithBonus;
    }

    public function setSalaryWithBonus(int $salaryWithBonus): self
    {
        $this->salaryWithBonus = $salaryWithBonus;

        return $this;
    }

    /**
     * @Groups("report")
     */
    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function setDepartment(Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getHiredAt(): DateTimeInterface
    {
        return $this->hiredAt;
    }

    public function setHiredAt(DateTimeInterface $hiredAt): self
    {
        $this->hiredAt = $hiredAt;

        return $this;
    }
}
