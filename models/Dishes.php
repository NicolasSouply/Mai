<?php

class Dishes
{
  
private ? int $id = null;

public function __construct(private string $name, private string $description, private int $price, private bool $vegetarian, private string $picture )
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
public function getName(): string
{
return $this->name;
}
public function setName($name) : void
{
$this->name = $name;
}
public function getDescription() : string
{
return $this->description;
}
public function setDescription($description) :void
{
$this->description = $description;
}
public function getPrice() : int
{
  return $this->price;
}
public function setPrice(int $price): void
{
    $this->price = $price;
}

public function getVegetarian(): bool
{
    return $this->vegetarian;
}

public function setVegetarian(bool $vegetarian): void
{
    $this->vegetarian = $vegetarian;
}

public function getPicture(): string
{
    return $this->picture;
}

public function setPicture(string $picture): void
{
    $this->picture = $picture;
}

}