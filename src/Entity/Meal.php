<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ingredients = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $allergen = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $container = null;

    #[ORM\Column]
    private ?bool $cutlery = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(length: 255)]
    private ?string $place = null;

    #[ORM\Column]
    private ?int $shares = null;

    #[ORM\ManyToOne(inversedBy: 'meals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $chef = null;

    #[ORM\Column]
    private ?float $price = 0.0;

    #[ORM\Column]
    private ?int $remainingShares = null;

    #[ORM\OneToMany(mappedBy: 'meal', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $disclaimer = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getAllergen(): ?string
    {
        return $this->allergen;
    }

    public function setAllergen(string $allergen): self
    {
        $this->allergen = $allergen;

        return $this;
    }

    public function getContainer(): ?string
    {
        return $this->container;
    }

    public function setContainer(?string $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function isCutlery(): ?bool
    {
        return $this->cutlery;
    }

    public function setCutlery(bool $cutlery): self
    {
        $this->cutlery = $cutlery;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getShares(): ?int
    {
        return $this->shares;
    }

    public function setShares(int $shares): self
    {
        $this->shares = $shares;

        return $this;
    }

    public function getChef(): ?User
    {
        return $this->chef;
    }

    public function setChef(?User $chef): self
    {
        $this->chef = $chef;

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

    public function getRemainingShares(): ?int
    {
        return $this->remainingShares;
    }

    public function setRemainingShares(int $remainingShares): self
    {
        $this->remainingShares = $remainingShares;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setMeal($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getMeal() === $this) {
                $order->setMeal(null);
            }
        }

        return $this;
    }

    public function getDisclaimer(): ?string
    {
        return $this->disclaimer;
    }

    public function setDisclaimer(?string $disclaimer): self
    {
        $this->disclaimer = $disclaimer;

        return $this;
    }

}
