<?php

class Clients
{
  private ? int $id = null;

  public function __construct(private string $firstName, private string $lastName, private string $email, private string $phone, private string $password)
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
  public function getFirstName(): string
  {
    return $this->firstName;
  }
  public function setFirstName($firstName): void
  {
    $this->firstName = $firstName;
  }

  public function getLastName(): string
  {
    return $this->lastName;
  }
  public function setLastName($lastName): void
  {
    $this->lastName = $lastName;
  }
  public function getEmail(): string
  {
    return $this->email;
  }
  public function setEmail($email): void
  {
    $this->email = $email;
  }
  public function getPhone(): string
  {
    return $this->phone;
  }
  public function setPhone($phone): void
  {
    $this->phone = $phone;
  }
  public function getPassword(): string
  {
    return $this->password;
  }
  public function setPassword($password): void
  {
    $this->password = $password;
  }
}