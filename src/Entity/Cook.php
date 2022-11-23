<?php

namespace App\Entity;

use App\Repository\CookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CookRepository::class)]
class Cook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $shift_start = null;

    #[ORM\Column]
    private ?int $shift_end = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstnameCook(): ?string
    {
        return $this->firstname;
    }

    public function setFirstnameCook(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastnameCook(): ?string
    {
        return $this->lastname;
    }

    public function setLastnameCook(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDescriptionCook(): ?string
    {
        return $this->description;
    }

    public function setDescriptionCook(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBeginCook(): ?int
    {
        return $this->shift_start;
    }

    public function setBeginCook(int $shift_start): self
    {
        $this->shift_start = $shift_start;

        return $this;
    }

    public function getEndCook(): ?int
    {
        return $this->shift_end;
    }

    public function setEndCook(int $shift_end): self
    {
        $this->shift_end = $shift_end;

        return $this;
    }
}
