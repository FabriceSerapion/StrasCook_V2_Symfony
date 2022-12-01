<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(
        message: 'Le nom d\'utilisateur est nécessaire !'
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: '{{ value }} est trop long, veuillez entrer maximum {{ limit }} caractères.'
    )]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string', length: 255)]
    // ! this validation cause issue, this is why it is commented for now
    // #[Assert\NotBlank(message: 'Le nom d\'utilisateur est nécessaire !')]
    #[Assert\Length(max: 255, maxMessage: '{{ value }} est trop long, veuillez entrer maximum {{ limit }} caractères.')]
    private ?string $password = null;

    #[ORM\OneToMany(
        mappedBy: 'customer',
        targetEntity: Booking::class
    )]
    // this side of the relation will probably be useful to get a history of past bookings
    private Collection $bookings;

    #[ORM\OneToMany(
        mappedBy: 'customer',
        targetEntity: UserRating::class
    )]
    private Collection $ratings;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // var_dump($roles);die();
        if(!$roles) {
            $roles[] = 'ROLE_USER';
            return array_unique($roles);
        } else {
            return array_unique($roles[0]);
        }
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBooking(): Collection
    {
        return $this->bookings;
    }

    /**
     * @return Collection<int, UserRating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }
}
