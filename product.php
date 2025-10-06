<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Paris');
class Product
{
    private int $id = 58;
    private string $name;
    private array $photos;
    private int  $price;
    private string $description;
    private int $quantity;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    

    // Constructeur
    public function __construct(int $id,string $name,array $photos,int $price,string $description,int $quantity,DateTime $createdAt,DateTime $updatedAt)
    {
    $this->id = $id;
    $this->name = $name;
    $this->photos = $photos;
    $this->price = $price;
    $this->description = $description;
    $this->quantity = $quantity;
    $this->createdAt = $createdAt;
    $this->updatedAt = $updatedAt;
    }

     // Getters et Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
        
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}