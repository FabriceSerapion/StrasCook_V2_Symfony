<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_appetizer = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_starter = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_meal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_dessert = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_cheese = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_cuteness = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'menus')]
    private Collection $tags;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'menus')]
    private Collection $usersRating;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->usersRating = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMenu(): ?string
    {
        return $this->name;
    }

    public function setNameMenu(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPriceMenu(): ?float
    {
        return $this->price;
    }

    public function setPriceMenu(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRatingMenu(): ?float
    {
        return $this->rating;
    }

    public function setRatingMenu(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDescrMenuAppetizer(): ?string
    {
        return $this->descr_appetizer;
    }

    public function setDescrMenuAppetizer(?string $descr_appetizer): self
    {
        $this->descr_appetizer = $descr_appetizer;

        return $this;
    }

    public function getDescrMenuStarter(): ?string
    {
        return $this->descr_starter;
    }

    public function setDescrMenuStarter(?string $descr_starter): self
    {
        $this->descr_starter = $descr_starter;

        return $this;
    }

    public function getDescrMenuMeal(): ?string
    {
        return $this->descr_meal;
    }

    public function setDescrMenuMeal(?string $descr_meal): self
    {
        $this->descr_meal = $descr_meal;

        return $this;
    }

    public function getDescrMenuDessert(): ?string
    {
        return $this->descr_dessert;
    }

    public function setDescrMenuDessert(?string $descr_dessert): self
    {
        $this->descr_dessert = $descr_dessert;

        return $this;
    }

    public function getDescrMenuCheese(): ?string
    {
        return $this->descr_cheese;
    }

    public function setDescrMenuCheese(?string $descr_cheese): self
    {
        $this->descr_cheese = $descr_cheese;

        return $this;
    }

    public function getDescrMenuCuteness(): ?string
    {
        return $this->descr_cuteness;
    }

    public function setDescrMenuCuteness(?string $descr_cuteness): self
    {
        $this->descr_cuteness = $descr_cuteness;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersRating(): Collection
    {
        return $this->usersRating;
    }

    public function addUsersRating(User $usersRating): self
    {
        if (!$this->usersRating->contains($usersRating)) {
            $this->usersRating->add($usersRating);
        }

        return $this;
    }

    public function removeUsersRating(User $usersRating): self
    {
        $this->usersRating->removeElement($usersRating);

        return $this;
    }
}
