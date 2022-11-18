<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_booking = null;

    #[ORM\Column(length: 255)]
    private ?string $adress_booking = null;

    #[ORM\Column]
    private ?float $price_prestation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBooking(): ?\DateTimeInterface
    {
        return $this->date_booking;
    }

    public function setDateBooking(\DateTimeInterface $date_booking): self
    {
        $this->date_booking = $date_booking;

        return $this;
    }

    public function getAdressBooking(): ?string
    {
        return $this->adress_booking;
    }

    public function setAdressBooking(string $adress_booking): self
    {
        $this->adress_booking = $adress_booking;

        return $this;
    }

    public function getPricePrestation(): ?float
    {
        return $this->price_prestation;
    }

    public function setPricePrestation(float $price_prestation): self
    {
        $this->price_prestation = $price_prestation;

        return $this;
    }
}
