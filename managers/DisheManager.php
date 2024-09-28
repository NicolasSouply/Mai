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
    
    public function saveDishe(Dishes $dishe): bool
    {
        try {
            if ($dishe->getId()) {
                // Mise à jour
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
            } else {
                // Insertion
                $query = $this->db->prepare('
                    INSERT INTO dishes (category, name, description, price, vegetarian, picture) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ');
                return $query->execute([
                    $dishe->getCategory(),
                    $dishe->getName(), 
                    $dishe->getDescription(), 
                    $dishe->getPrice(), 
                    $dishe->getIsVegetarian(), 
                    $dishe->getPicture()
                ]);
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la sauvegarde du plat : " . $e->getMessage());
            return false;
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
        //var_dump($dishes); // Vérifie les données récupérées

            return $dishes;
        
    }
    


    public function updateDishe(Dishes $dishe): bool
    {
        if ($dishe->getId()) {
            $query = $this->db->prepare("
                UPDATE dishes SET 
                    category = :category, 
                    name = :name, 
                    price = :price, 
                    vegetarian = :vegetarian, 
                    description = :description, 
                    picture = :picture 
                WHERE dishe_id = :dishe_id
            ");
    
            if (!$query) {
                var_dump("Erreur de préparation de la requête : " . implode(", ", $this->db->errorInfo()));
                return false;
            }
    
            var_dump("Exécution de la requête de mise à jour pour l'ID : " . $dishe->getId());
    
            $success = $query->execute([
                'category' => $dishe->getCategory(),
                'name' => $dishe->getName(),
                'price' => $dishe->getPrice(),
                'vegetarian' => $dishe->getIsVegetarian(),
                'description' => $dishe->getDescription(),
                'picture' => $dishe->getPicture(),
                'dishe_id' => $dishe->getId()
            ]);
    
            if ($success) {
                if ($query->rowCount() > 0) {
                    return true; // Mise à jour réussie
                } else {
                    var_dump("Aucune ligne mise à jour pour l'ID : " . $dishe->getId());
                    return false; // Pas de changement
                }
            } else {
                var_dump("Erreur lors de l'exécution de la mise à jour : " . implode(", ", $query->errorInfo()));
            }
        }
        
        return false; // Aucun ID fourni
    }
    
    
    

public function deleteDishe(int $id): bool
{
    $query = $this->db->prepare('DELETE FROM dishes WHERE dishe_id = ?');
    return $query->execute([$id]);
}

  
}