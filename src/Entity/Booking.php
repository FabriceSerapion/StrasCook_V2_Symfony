<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(
        type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(
        type: 'string',
        length: 255)]
    #[Assert\NotBlank(
        message: 'L\'adresse de prestation est nécessaire !')]
    #[Assert\Length(
        max: 255,
        maxMessage: '{{ value }} est trop long, veuillez entrer maximum {{ limit }} caractères.')]
    private ?string $adress = null;

    // This field is generated by the app (sum of all prices)
    // Validation isn't really necessary
    #[ORM\Column(
        type: Types::FLOAT
        )]
    #[Assert\NotBlank(message: 'Le prix de la réservation est nécessaire !')]
    private ?float $price = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(
        nullable: false)]
    private ?Menu $menu = null;

    #[ORM\ManyToOne(
        inversedBy: 'bookings')]
    #[ORM\JoinColumn(
        nullable: false)]
    private ?Cook $cook = null;

    #[ORM\ManyToOne(
        inversedBy: 'bookings')]
    #[ORM\JoinColumn(
        nullable: false)]
    private ?User $customer = null;

    #[ORM\Column(
        type: 'integer')]
    #[Assert\NotBlank(
        message: 'Le nombre de menu est nécessaire !')]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'Veuillez commander de 1 à 5 menus.'
    )]
    private ?int $quantity = null;

    #[ORM\Column(
        type: 'integer')]
    #[Assert\NotBlank(
        message: 'L\'heure de départ est nécessaire !')]
    #[Assert\Range(
        min: 0,
        max: 23,
        notInRangeMessage: 'Veuillez indiquer une heure, de 00 à 23.'
    )]
    private ?int $time = null;

    private int $rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date->format('Y-m-d');
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getCook(): ?Cook
    {
        return $this->cook;
    }

    public function setCook(?Cook $cook): self
    {
        $this->cook = $cook;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->date->format('H:i');
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
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
}
