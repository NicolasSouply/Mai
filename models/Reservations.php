<?php

class Reservations
{
  private ? int $id = null;

  public function __construct(private DateTime $date, private DateTime $hour, private int $nb_persons)
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
  public function getDate(): dateTime
  {
    return $this->date;
  }
  public function setDate($date): void
  {
    $this->date = $date;
  }
  public function getHour(): dateTime
  {
    return $this->hour;
  }
  public function setHour($hour): void
  {
    $this->hour = $hour;
  }
  public function getNb_persons(): int
  {
    return $this->nb_persons;
  }
  public function setNb_persons($nb_persons): void
  {
    $this->nb_persons = $nb_persons;
  }
  }
  