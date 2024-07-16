<?php

class Dishes
{
  
private ? int $id = null;

public function __construct(private string $name, private string $description)
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
}