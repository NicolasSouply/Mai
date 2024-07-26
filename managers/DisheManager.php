<?php 

class DisheManager extends AbstractManager 
{

  private $dishes  = [];


  public function saveDishe(Dishes $dishe) 
    {
        $query = $this->db->prepare('INSERT INTO dishes (name, description, price, vegetarian, picture) VALUES (?, ?, ?, ?, ?)');
        $query->execute([
            $dishe->getName(), 
            $dishe->getDescription(), 
            $dishe->getPrice(), 
            $dishe->getVegetarian(), 
            $dishe->getPicture()
        ]);
    }
  public function findAll() : array
  {
        $query = $this->db->prepare('SELECT * FROM dishes');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $dishes = [];

        foreach($result as $item)
        {
            $dishe = new Dishes($item["name"], $item["description"], $item["price"], $item["vegetarian"], $item["picture"]);
            $dishe->setId($item["id"]);
            $dishes[] = $dishe;
        }

        return $dishes;
  }
  
  
}