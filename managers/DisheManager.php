<?php 

class DisheManager extends AbstractManager 
{
    public function findById(int $id): ?Dishes
    {
        $query = $this->db->prepare('SELECT * FROM dishes WHERE dishe_id = ?');
        $query->execute([$id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            $dishe = new Dishes(
                $result['category'],
                $result['name'],
                $result['description'],
                $result['price'],
                $result['vegetarian'],
                $result['picture']
            );
            $dishe->setId($result['dishe_id']);
            return $dishe;
        }
    
        return null;
    }
    
    public function saveDishe(Dishes $dishe) 
    {
        if ($dishe->getId()) {
            // Mise à jour
            $query = $this->db->prepare('
                UPDATE dishes 
                SET category = ?, name = ?, description = ?, price = ?, vegetarian = ?, picture = ? 
                WHERE dishe_id = ?
            ');
            $query->execute([
                $dishe->getCategory(),
                $dishe->getName(), 
                $dishe->getDescription(), 
                $dishe->getPrice(), 
                $dishe->getIsVegetarian(), 
                $dishe->getPicture(),
                $dishe->getId()
            ]);
        } else {
            // Insertion
            $query = $this->db->prepare('
                INSERT INTO dishes (category, name, description, price, vegetarian, picture) 
                VALUES (?, ?, ?, ?, ?, ?)
            ');
            $query->execute([
                $dishe->getCategory(),
                $dishe->getName(), 
                $dishe->getDescription(), 
                $dishe->getPrice(), 
                $dishe->getIsVegetarian(), 
                $dishe->getPicture()
            ]);
        }
    }
    public function findAll(): array
    {
        
            $query = $this->db->prepare('SELECT * FROM dishes');
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    

            $dishes = [];
            foreach ($result as $item) {
                $dishe = new Dishes(
                    $item['category'],
                    $item['name'],
                    $item['description'],
                    $item['price'],
                    $item['vegetarian'],
                    $item['picture']
                );
                $dishe->setId($item['dishe_id']);
                $dishes[] = $dishe;
            }
        var_dump($dishes); // Vérifie les données récupérées

            return $dishes;
        
    }
    


public function updateDishe(Dishes $dishe): bool
{
    if ($dishe->getId()) {
        $query = $this->db->prepare('
            UPDATE dishes 
            SET category = ?, name = ?, description = ?, price = ?, vegetarian = ?, picture = ? 
            WHERE dishe_id = ?
        ');
        return $query->execute([
            $dishe->getCategory(),
            $dishe->getName(), 
            $dishe->getDescription(), 
            $dishe->getPrice(), 
            $dishe->getIsVegetarian(),
            $dishe->getPicture(),
            $dishe->getId()
        ]);
    }

    return false;
}

public function deleteDishe(int $id): bool
{
    $query = $this->db->prepare('DELETE FROM dishes WHERE dishe_id = ?');
    return $query->execute([$id]);
}

  
}