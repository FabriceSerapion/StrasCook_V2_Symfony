<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTag(): ?string
    {
        return $this->name;
    }

    public function setNameTag(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
