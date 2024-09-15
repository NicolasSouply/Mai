<?php

class Dishes
{
  
private ? int $id = null;

public function __construct(private string $category, private string $name, private string $description, private float $price, private bool $isVegetarian, private string $picture )
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
public function getCategory(): string
{
return $this->category;
}

public function setCategory($category): void
  {
    $this->category = $category;
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
public function getPrice() :  float
{
  return $this->price;
}
public function setPrice(float $price): void
{
    $this->price = $price;
}

public function getIsVegetarian(): bool
{
    return $this->isVegetarian;
}

public function setIsVegetarian(bool $isVegetarian): void
{
    $this->isVegetarian = $isVegetarian;
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