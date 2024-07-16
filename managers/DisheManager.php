<?php 

class DisheManager extends AbstractManager 
{

  public function findAll() : array
  {
    $query = $this->db->prepare('SELECT * FROM dishes');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $dishes = [];

        foreach($result as $item)
        {
            $dishe = new Dishes($item["name"], $item["description"]);
            $dishe->setId($item["id"]);
            $dishes[] = $dishe;
        }

        return $dishes;
  }
}