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
    private ?string $name_tag = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTag(): ?string
    {
        return $this->name_tag;
    }

    public function setNameTag(string $name_tag): self
    {
        $this->name_tag = $name_tag;

        return $this;
    }
}
