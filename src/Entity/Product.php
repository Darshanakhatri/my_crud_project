<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2, nullable: true)]
    private ?string $discount = null;

    #[ORM\Column(type: 'integer')]
    private ?int $quantity = null;

    #[ORM\Column(type: 'integer')]
    private ?int $soldQuantity = 0;

  


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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): self
    {
        $this->discount = $discount;
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
    
    public function getSoldQuantity(): ?int
    {
        return $this->soldQuantity;
    }
    
    public function setSoldQuantity(int $soldQuantity): self
    {
        $this->soldQuantity = $soldQuantity;
        return $this;
    }
    
    // Calculate unsold dynamically (not stored)
    public function getUnsoldQuantity(): int
    {
        return max(0, ($this->quantity ?? 0) - ($this->soldQuantity ?? 0));
    }
    // after discount price per product
    public function getPriceAfterDiscount(): float
    {
        $unitPrice = (float) $this->price;
        $discountPercent = (float) $this->discount ?? 0;

        $discountAmount = ($discountPercent / 100) * $unitPrice;

        return $unitPrice - $discountAmount;
    }


    public function getActualPrice(): float
    {
        $unitPrice = (float) $this->price;
        $quantity = $this->quantity ?? 0;

        return $unitPrice * $quantity;
    }

    public function getTotalPrice(): float
    {
        // Convert price and discount to float for calculation
        $unitPrice = (float) $this->price;
        $discountPercent = (float) ($this->discount ?? 0);
        $quantity = $this->quantity ?? 0;

        // Calculate discounted price per unit
        $discountAmount = $unitPrice * ($discountPercent / 100);
        $priceAfterDiscount = $unitPrice - $discountAmount;

        // Total price = price after discount * quantity
        return $priceAfterDiscount * $quantity;
    }

  
}
