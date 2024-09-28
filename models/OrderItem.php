<?php 
class OrderItem
{
    private string $name;  // Le nom de l'article
    private float $price;  // Le prix unitaire de l'article
    private int $quantity; // La quantité commandée

    public function __construct(string $name, float $price, int $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotalPrice(): float
    {
        return $this->price * $this->quantity;
    }
}
