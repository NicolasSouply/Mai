<?php 

class ReservationManager extends AbstractManager 
{

  public function findAll() : array
  {
    $query = $this->db->prepare('SELECT * FROM reservation');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $reservations = [];

        foreach($result as $item)
        {
            $reservation = new Reservations($item["day"], $item["hour"], $item["nb_persons"]);
            $reservation->setId($item["id"]);
            $reservations[] = $reservation;
        }

        return $reservations;
  }
}