<?php 

class ClientManager extends AbstractManager 
{

  public function findAll() : array
  {
    $query = $this->db->prepare('SELECT * FROM clients');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $clients = [];

        foreach($result as $item)
        {
            $client = new Clients($item["firstName"], $item["lastName"], $item["email"], $item["phone"], $item["password"]);
            $client->setId($item["id"]);
            $clients[] = $client;
        }

        return $clients;
  }
}