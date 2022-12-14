<?php

namespace App\Entity;

use App\Repository\CookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CookRepository::class)]
class Cook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(
        type: 'string',
        length: 50)]
    #[Assert\NotBlank(
        message: 'Le prénom du cuisinier est nécessaire !')]
    #[Assert\Length(
        max: 50,
        maxMessage: '{{ value }} est trop long, veuillez entrer maximum {{ limit }} caractères.')]
    private ?string $firstname = null;

    #[ORM\Column(
        type: 'string',
        length: 50)]
    #[Assert\NotBlank(
        message: 'Le nom de famille du cuisinier est nécessaire !')]
    #[Assert\Length(
        max: 50,
        maxMessage: '{{ value }} est trop long, veuillez entrer maximum {{ limit }} caractères.')]
    private ?string $lastname = null;

    #[ORM\Column(
        type: Types::TEXT,
        nullable: true)]
    private ?string $description = null;

    #[ORM\Column(
        type: 'integer')]
    #[Assert\NotBlank(
        message: 'L\'heure de départ est nécessaire !')]
    #[Assert\Range(
        min: 0,
        max: 23,
        notInRangeMessage: 'Veuillez indiquer une heure, de 00 à 23.'
    )]
    private ?int $shift_start = null;

    #[ORM\Column(
        type: 'integer')]
    #[Assert\NotBlank(
        message: 'L\'heure de fin est nécessaire !')]
    #[Assert\Range(
        min: 0,
        max: 23,
        notInRangeMessage: 'Veuillez indiquer une heure, de 00 à 23.'
    )]
    private ?int $shift_end = null;

    #[ORM\OneToMany(
        mappedBy: 'cook',
        targetEntity: Booking::class)]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShiftStart(): ?int
    {
        return $this->shift_start;
    }

    public function setShiftStart(int $shift_start): self
    {
        $this->shift_start = $shift_start;

        return $this;
    }

    public function getShiftEnd(): ?int
    {
        return $this->shift_end;
    }

    public function setShiftEnd(int $shift_end): self
    {
        $this->shift_end = $shift_end;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setCook($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCook() === $this) {
                $booking->setCook(null);
            }
        }

        return $this;
    }
}
