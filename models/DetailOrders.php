<?php

class DetailOrders 
{

  private ? int $id = null;

  public function __construct(private float $price, private int $quantity)
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
  public function getPrice(): float
  {
    return $this->price;
  }
  public function setPrice($price)
  {
    $this->price = $price;
  }
  public function getQuantity(): float
  {
    return $this->quantity;
  }
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;
  }
}