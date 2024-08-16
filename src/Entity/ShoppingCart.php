<?php

namespace App\Entity;

use App\Repository\ShoppingCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingCartRepository::class)]
class ShoppingCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, CartItem>
     */
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'shoppingCart', orphanRemoval: true)]
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
            $cartItem->setShoppingCart($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getShoppingCart() === $this) {
                $cartItem->setShoppingCart(null);
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(fn(CartItem $cartItem) => $cartItem->toArray(), $this->getCartItems()->toArray()),
            'total' => array_sum(
                array_map(
                    function(CartItem $cartItem) {
                        $total = 0;
                        foreach ($cartItem->getProduct() as $product) {
                            $total += $product->getTotalByQuantity($cartItem->getQuantity());
                        }

                        /**
                         * @var Product $product
                         */
                        $product = $cartItem->getProduct()->first();
                        
                        if ($product->isWeighted()) {
                            $product = $product::getProductInstance($product, WeightedProduct::class);
                        }
                        else {
                            $product = $product::getProductInstance($product, CountableProduct::class);
                        }

                        return $product->getTotalByQuantity($cartItem->getQuantity());
                    },
                    $this->getCartItems()->toArray()
                )
            ),
        ];
    }
}
