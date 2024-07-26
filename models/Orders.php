<?php

class Orders
{
  private ? int $id = null;

  public function __construct(private string $status, private float $totalPrice, private DateTime $date_order, private DateTime $hour_order)
{
  
}
public function getId(): ?int
  {
    return $this->id;
  }
  public function setId(?int $id) : void
  {
    $this->id = $id;
  }
  public function getStatus(): string
  {
    return $this->status;
  }
  public function setStatus($status): void
  {
    $this->status = $status;
  }

  public function getTotalPrice(): float
  {
    return $this->totalPrice;
  }
  public function setTotalPrice($totalPrice): void
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
}