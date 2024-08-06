<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

#[UniqueEntity('externalId', message: 'This externalId {{ value }} exists already in the database.')]
#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $externalId = null;

    #[ORM\Column(length: 255)]
    private ?string $categoryName = null;

    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4, nullable: true)]
    #[Type(type: 'numeric', message: 'The price {{ value }} is not a valid number.')]
    #[PositiveOrZero]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[Range(min: 0, max: 5)]
    #[ORM\Column]
    private int $rating = 0;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $caffeineType = null;

    #[ORM\Column(nullable: true)]
    private ?int $count = null;

    #[ORM\Column(nullable: true)]
    private ?bool $flavored = null;

    #[ORM\Column(nullable: true)]
    private ?bool $seasonal = null;

    #[ORM\Column]
    private bool $inStock = false;

    #[ORM\Column]
    private bool $facebook = false;

    #[ORM\Column]
    private bool $isKCup = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): static
    {
        $this->externalId = $externalId;
        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCaffeineType(): ?string
    {
        return $this->caffeineType;
    }

    public function setCaffeineType(?string $caffeineType): static
    {
        $this->caffeineType = $caffeineType;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function isFlavored(): ?bool
    {
        return $this->flavored;
    }

    public function setFlavored(?bool $flavored): static
    {
        $this->flavored = $flavored;

        return $this;
    }

    public function isSeasonal(): ?bool
    {
        return $this->seasonal;
    }

    public function setSeasonal(?bool $seasonal): static
    {
        $this->seasonal = $seasonal;

        return $this;
    }

    public function isInStock(): ?bool
    {
        return $this->inStock;
    }

    public function setInStock(bool $inStock): static
    {
        $this->inStock = $inStock;

        return $this;
    }

    public function isFacebook(): ?bool
    {
        return $this->facebook;
    }

    public function setFacebook(bool $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getIsKCup(): ?bool
    {
        return $this->isKCup;
    }

    public function setIsKCup(bool $isKCup): static
    {
        $this->isKCup = $isKCup;

        return $this;
    }
}
