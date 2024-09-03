<?php 

class CategoryManager extends AbstractManager 
{

  public function findAll() : array
  {
    $query = $this->db->prepare('SELECT * FROM categories');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $category = [];

        foreach($result as $item)
        {
            $category = new Categories($item["category"]);
            $category->setId($item["id"]);
            $categories[] = $category;
        }

        return $categories;
  }
}