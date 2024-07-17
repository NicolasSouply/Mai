<?php 

class ClientManager extends AbstractManager 
{

  public function findAll() : array
  {
    $query = $this->db->prepare('SELECT * FROM contacts');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $contacts = [];

        foreach($result as $item)
        {
            $contact = new Clients($item["firstName"], $item["lastName"], $item["email"], $item["phone"], $item["password"]);
            $contact->setId($item["id"]);
            $contacts[] = $contact;
        }

        return $contacts;
  }
}