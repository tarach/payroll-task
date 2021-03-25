<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 */
class Department
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $bonusConstant;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private ?int $bonusPercentage;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @Groups("report")
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBonusConstant(): ?int
    {
        return $this->bonusConstant;
    }

    public function setBonusConstant(?int $bonusConstant): self
    {
        $this->bonusConstant = $bonusConstant;

        return $this;
    }

    public function getBonusPercentage(): ?int
    {
        return $this->bonusPercentage;
    }

    public function setBonusPercentage(?int $bonusPercentage): self
    {
        $this->bonusPercentage = $bonusPercentage;

        return $this;
    }
}
