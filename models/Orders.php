<?php

class Orders
{
    private ?int $order_id = null;
    private array $items = []; // Propriété pour les articles de commande

    public function __construct(
        private string $status, 
        private float $totalPrice, 
        private DateTime $date_order, 
        private DateTime $hour_order
    ) 
    {
      
    }

    public function getOrder_id(): ?int
    {
        return $this->order_id;
    }

    public function setOrder_id(?int $order_id): void
    {
        $this->order_id = $order_id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getDate_order(): DateTime
    {
        return $this->date_order;
    }

    public function setDate_order(DateTime $date_order): void
    {
        $this->date_order = $date_order;
    }

    public function getHour_order(): DateTime
    {
        return $this->hour_order;
    }

    public function setHour_order(DateTime $hour_order): void
    {
        $this->hour_order = $hour_order;
    }

    // Ajouter un article à la commande
    public function addItem(OrderItem $item): void
    {
        $this->items[] = $item;  // Ajoute l'article à la liste
        $this->updateTotalPrice();  // Met à jour le prix total après ajout
    }

    // Enlever un article de la commande
    public function removeItem(OrderItem $item): void
    {
        $this->items = array_filter($this->items, fn($i) => $i !== $item);  // Retire l'article de la liste
        $this->updateTotalPrice();  // Met à jour le prix total après suppression
    }

    // Getter pour obtenir tous les articles
    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
        $this->updateTotalPrice();  // Met à jour le prix total après avoir remplacé les articles
    }

    // Calculer et mettre à jour le prix total de la commande
    private function updateTotalPrice(): void
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            error_log("Item: {$item->getName()} - Price: {$item->getPrice()} - Quantity: {$item->getQuantity()} - Total: {$item->getTotalPrice()}");
            $total += $item->getTotalPrice();  // Somme des prix de chaque article
        }
        error_log("Total Price for Order: " . $total);  // Log le total final
        $this->totalPrice = $total;
    }
    
}
