<?php

namespace App\Entity;

use App\Repository\MenuRepository;
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
    private ?string $name_menu = null;

    #[ORM\Column]
    private ?float $price_menu = null;

    #[ORM\Column(nullable: true)]
    private ?float $note_menu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_menu_appetizer = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_menu_starter = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_menu_meal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_menu_dessert = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_menu_cheese = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descr_menu_cuteness = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMenu(): ?string
    {
        return $this->name_menu;
    }

    public function setNameMenu(string $name_menu): self
    {
        $this->name_menu = $name_menu;

        return $this;
    }

    public function getPriceMenu(): ?float
    {
        return $this->price_menu;
    }

    public function setPriceMenu(float $price_menu): self
    {
        $this->price_menu = $price_menu;

        return $this;
    }

    public function getNoteMenu(): ?float
    {
        return $this->note_menu;
    }

    public function setNoteMenu(?float $note_menu): self
    {
        $this->note_menu = $note_menu;

        return $this;
    }

    public function getDescrMenuAppetizer(): ?string
    {
        return $this->descr_menu_appetizer;
    }

    public function setDescrMenuAppetizer(?string $descr_menu_appetizer): self
    {
        $this->descr_menu_appetizer = $descr_menu_appetizer;

        return $this;
    }

    public function getDescrMenuStarter(): ?string
    {
        return $this->descr_menu_starter;
    }

    public function setDescrMenuStarter(?string $descr_menu_starter): self
    {
        $this->descr_menu_starter = $descr_menu_starter;

        return $this;
    }

    public function getDescrMenuMeal(): ?string
    {
        return $this->descr_menu_meal;
    }

    public function setDescrMenuMeal(?string $descr_menu_meal): self
    {
        $this->descr_menu_meal = $descr_menu_meal;

        return $this;
    }

    public function getDescrMenuDessert(): ?string
    {
        return $this->descr_menu_dessert;
    }

    public function setDescrMenuDessert(?string $descr_menu_dessert): self
    {
        $this->descr_menu_dessert = $descr_menu_dessert;

        return $this;
    }

    public function getDescrMenuCheese(): ?string
    {
        return $this->descr_menu_cheese;
    }

    public function setDescrMenuCheese(?string $descr_menu_cheese): self
    {
        $this->descr_menu_cheese = $descr_menu_cheese;

        return $this;
    }

    public function getDescrMenuCuteness(): ?string
    {
        return $this->descr_menu_cuteness;
    }

    public function setDescrMenuCuteness(?string $descr_menu_cuteness): self
    {
        $this->descr_menu_cuteness = $descr_menu_cuteness;

        return $this;
    }
}
