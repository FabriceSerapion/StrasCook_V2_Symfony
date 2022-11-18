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
    private ?string $firstname_cook = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname_cook = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_cook = null;

    #[ORM\Column]
    private ?int $begin_cook = null;

    #[ORM\Column]
    private ?int $end_cook = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstnameCook(): ?string
    {
        return $this->firstname_cook;
    }

    public function setFirstnameCook(string $firstname_cook): self
    {
        $this->firstname_cook = $firstname_cook;

        return $this;
    }

    public function getLastnameCook(): ?string
    {
        return $this->lastname_cook;
    }

    public function setLastnameCook(string $lastname_cook): self
    {
        $this->lastname_cook = $lastname_cook;

        return $this;
    }

    public function getDescriptionCook(): ?string
    {
        return $this->description_cook;
    }

    public function setDescriptionCook(?string $description_cook): self
    {
        $this->description_cook = $description_cook;

        return $this;
    }

    public function getBeginCook(): ?int
    {
        return $this->begin_cook;
    }

    public function setBeginCook(int $begin_cook): self
    {
        $this->begin_cook = $begin_cook;

        return $this;
    }

    public function getEndCook(): ?int
    {
        return $this->end_cook;
    }

    public function setEndCook(int $end_cook): self
    {
        $this->end_cook = $end_cook;

        return $this;
    }
}
