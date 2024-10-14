<?php

class OrderManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }


    public function storeOrder(array $cartItems, int $userId): int
    {
        

        error_log("Contenu du panier : " . json_encode($cartItems));
    
        $cartTotal = 0.0;
    
        // Calculer le total du panier
        foreach ($cartItems as $item) {
            if (isset($item['price'], $item['quantity'])) {
                $cartTotal += $item['price'] * $item['quantity'];
            } else {
                var_dump("Erreur : Données manquantes pour l'article " . json_encode($item));
            }
        }
    
        error_log("Total calculé : $cartTotal");
    
        try {
            // Démarrer la transaction
            $this->db->beginTransaction();
    
            // Insérer la commande
            $order_id = $this->insertOrder($userId, $cartTotal);
            if (!$order_id) {
                throw new Exception("L'insertion de la commande a échoué.");
            }
            error_log("Commande créée avec l'ID : $order_id");
    
            // Insérer les articles du panier
            foreach ($cartItems as $item) {
                $this->insertOrderItem($order_id, $item);
            }
    
            // Valider la transaction
            $this->db->commit();
            return $order_id;
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollBack();
            error_log("Erreur lors de la création de la commande : " . $e->getMessage());
            throw new Exception("Erreur lors de la création de la commande : " . $e->getMessage());
        }
    }
    
    
    


private function insertOrder(int $userId, float $total): int
{error_log("Tentative d'insertion de la commande : userId=$userId, total_price=$total");

    $query = $this->db->prepare("INSERT INTO orders (user_id, total_price, status, date_order, hour_order) 
                                 VALUES (:user_id, :total_price, 'Pending', NOW(), NOW())");

    // Liaison des paramètres
    $query->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $query->bindValue(':total_price', $total, PDO::PARAM_STR);

    // Exécution de la requête et gestion des erreurs
    if (!$query->execute()) {
        error_log("Erreur lors de l'insertion de la commande : " . implode(", ", $query->errorInfo()));
        throw new Exception("Erreur lors de l'insertion de la commande.");
    }

    // Retourne l'ID de la commande
    return (int)$this->db->lastInsertId();
}


private function insertOrderItem(int $order_id, array $item): void
{error_log("Insertion de l'article : " . json_encode($item));

    // Vérification des données
    if (!isset($item['dishe_id'], $item['total_price'], $item['quantity'])) {
        error_log("Données manquantes pour l'article : " . json_encode($item));
        return; // Sortir si les données sont manquantes
    }

    $query = $this->db->prepare("INSERT INTO detail_orders (order_id, dishe_id, total_price, quantity) 
        VALUES (:order_id, :dishe_id, :total_price, :quantity)");

    // Lier les paramètres
    $query->bindValue(':order_id', $order_id);
    $query->bindValue(':dishe_id', $item['dishe_id']); // Correction ici
    $query->bindValue(':total_price', $item['total_price']);
    $query->bindValue(':quantity', $item['quantity']);

    // Exécution de la requête et gestion des erreurs
    if (!$query->execute()) {
        error_log("Erreur lors de l'insertion de l'article : " . implode(", ", $query->errorInfo()));
    } else {
        error_log("Article inséré avec succès dans detail_orders pour la commande ID : $order_id");
    }
}


    public function getOrderById(int $order_id ): Orders
    {
        $query = 'SELECT * FROM orders WHERE order_id = :order_id';
        $stmt = $this->db->prepare($query);
        $stmt->execute(['order_id' => $order_id ]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            throw new Exception("Commande avec l'ID $order_id  non trouvée.");
        }

        $createdAt = !empty($order['created_at']) ? $order['created_at'] : '1970-01-01 00:00:00';
        $updatedAt = !empty($order['updated_at']) ? $order['updated_at'] : '1970-01-01 00:00:00';
        $total_price = !empty($order['total_price']) ? (float)$order['total_price'] : 0.0;

        return new Orders(
            $order['order_id'],
            $total_price,
            new DateTime($createdAt),
            new DateTime($updatedAt)
        );
    }

    public function getOrderItemsByOrderId($orderId) {
        $query = "SELECT dishe_id, quantity, price FROM detail_orders WHERE detail_order_id = :detail_order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':detail_order_id', $orderId);
        $stmt->execute();
        
        $orderItems = [];
        
        while ($itemData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Assurez-vous que les données sont présentes
            if ($itemData) {
                $orderItem = new OrderItem(
                    $itemData['dishe_id'], 
                    $itemData['price'], 
                    $itemData['quantity']
                );
                $orderItems[] = $orderItem;
            } else {
                error_log("Aucun article trouvé pour l'ID de commande : " . $orderId);
            }
        }
    
        return $orderItems; // Retourne la liste des articles de la commande
    }
    
    public function getOrdersByUserId($userId) {
        $query = "SELECT order_id, status, total_price, date_order, hour_order 
                  FROM orders WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        
        $orders = [];
    
        while ($orderData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Initialisation des propriétés avec des valeurs par défaut
            $order = new Orders(
                $orderData['status'], 
                $orderData['total_price'], 
                new DateTime($orderData['date_order']), 
                new DateTime($orderData['hour_order'])
            );
            
            // Définir l'ID de la commande
            $order->setOrder_id($orderData['order_id']);
            
            $orders[] = $order;
        }
    
        return $orders;
    }
    

}