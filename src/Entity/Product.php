<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\SequenceGenerator(sequenceName: "product_id_seq", initialValue: 1)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $units = null;

    #[ORM\Column]
    private ?bool $weighted = null;

    /**
     * @var Collection<int, CartItem>
     */
    #[ORM\ManyToMany(targetEntity: CartItem::class, mappedBy: 'product')]
    private Collection $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getUnits(): ?string
    {
        return $this->units;
    }

    public function setUnits(?string $units): static
    {
        $this->units = $units;

        return $this;
    }

    public function isWeighted(): ?bool
    {
        return $this->weighted;
    }

    public function setWeighted(bool $weighted): static
    {
        $this->weighted = $weighted;

        return $this;
    }

    /**
     * Returns the total price of the product by quantity
     *
     * @param integer $quantity
     * @return float
     */
    public function getTotalByQuantity(int $quantity): float
    {
        return $this->price * $quantity;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'units' => $this->units,
            'weighted' => $this->weighted,
        ];
    }

    public static function getProductInstance(Product $product, string $class): self
    {
        $specialized = new $class();
        $specialized->setId($product->getId());
        $specialized->setName($product->getName());
        $specialized->setPrice($product->getPrice());
        $specialized->setWeighted($product->isWeighted());

        return $specialized;
    }

    /**
     * @return Collection<int, CartItem>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): static
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems->add($cartItem);
            $cartItem->addProduct($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            $cartItem->removeProduct($this);
        }

        return $this;
    }
}
