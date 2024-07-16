<?php

class Categories 
{
  private ? int $id = null;

  public function __construct(private string $category)
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
  public function getCategory()
  {
    return $this->category;
  }

  public function setCategory($category)
  {
    $this->category = $category;
  }
}