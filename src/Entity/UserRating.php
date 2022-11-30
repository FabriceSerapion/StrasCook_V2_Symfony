<?php

namespace App\Entity;

use App\Repository\UserRatingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRatingRepository::class)]
class UserRating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(
        type: 'integer')]
    #[Assert\NotBlank(
        message: 'La note est nécessaire !')]
    #[Assert\Range(
        min: 0,
        max: 5,
        notInRangeMessage: 'Veuillez noter de 0 à 5.'
    )]
    private ?int $rating = null;

    #[ORM\ManyToOne(
        inversedBy: 'Ratings')]
    #[ORM\JoinColumn(
        nullable: false)]
    private ?User $customer = null;

    #[ORM\ManyToOne(
        inversedBy: 'ratings')]
    #[ORM\JoinColumn(
        nullable: false)]
    private ?Menu $menu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
