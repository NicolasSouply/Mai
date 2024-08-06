<?php

class Users
{
  private ? int $id = null;

  public function __construct(
      private string $first_name,
      private string $last_name,
      private string $email,
      private string $phone,
      private string $password,
      private string $role
  )
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
  public function getFirst_name(): string
  {
    return $this->first_name;
  }
  public function setFirst_name(string  $first_name): void
  {
    $this->first_name = $first_name;
  }

  public function getLast_name(): string
  {
    return $this->last_name;
  }
  public function setLast_name(string  $last_name): void
  {
    $this->last_name = $last_name;
  }
  public function getEmail(): string
  {
    return $this->email;
  }
  public function setEmail(string  $email): void
  {
    $this->email = $email;
  }
  public function getPhone(): string
  {
    return $this->phone;
  }
  public function setPhone(string  $phone): void
  {
    $this->phone = $phone;
  }
  public function getPassword(): string
  {
    return $this->password;
  }
  public function setPassword(string  $password): void
  {
    $this->password = $password;
  }

  public function getRole(): string
  {
    return $this->role;
  }
  public function setRole(string $role): void
  {
    $this->role = $role;

  }
}