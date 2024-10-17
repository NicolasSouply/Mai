<?php

class OrderController extends AbstractController
{
    private OrderManager $om;

    public function __construct()
    {
        parent::__construct();
        $this->om = new OrderManager();
    }

    private function isCartValid(): bool
    {
        return isset($_POST['cartItems']) && isset($_POST['cartTotal']);
    }

    public function createOrder(): void
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $this->handleError("Vous devez être connecté pour passer une commande.", 'user-zone');
            return;
        }
        
        // Vérifier et décoder les articles du panier
        $cartItems = isset($_POST['cartItems']) ? json_decode($_POST['cartItems'], true) : null;
        
        // Vérifier la validité du panier
        if ($this->isCartValid() && $cartItems !== null) {
            $userId = $_SESSION['user']->getId();
            if ($userId === null) {
                $this->handleError("Erreur d'utilisateur.", 'user-zone');
                return;
            }

            try {
                // Créer la commande en base de données et obtenir l'ID
                $order_id = $this->om->storeOrder($cartItems, $userId);
                
                // Rediriger vers la page de confirmation
                $this->redirectToOrderConfirmation($order_id);
            } catch (Exception $e) {
                error_log("Erreur lors de la création de la commande : " . $e->getMessage());
                $this->handleError("Erreur lors de la création de la commande.", 'user-zone');
            }
        } else {
            $this->handleError("Des informations sont manquantes pour créer la commande.", 'user-zone');
        }
    }
    
    // Méthode pour afficher la confirmation de commande
    public function orderConfirmation(int $order_id): void
    {
        // Vérifier si l'ID de commande est fourni
        if (!isset($_GET['order_id'])) {
            $this->handleError("ID de commande manquant.", 'user-zone');
            return;
        }

        // Récupérer l'ID de commande à partir de l'URL
        $order_id = (int)$_GET['order_id'];

        // Récupérer les articles de la commande
        $orderItems = $this->om->getOrderItemsByOrderId($order_id);

        if ($orderItems) {
            // Affichage de la page de confirmation avec les détails de la commande
            $this->render('confirmation.html.twig', [
                'cartItems' => $orderItems,
                'orderId' => htmlspecialchars($order_id, ENT_QUOTES, 'UTF-8'),
                'cartTotal' => array_reduce($orderItems, function($total, $item) {
                    return $total + $item->getTotalPrice();
                }, 0),
            ]);
        } else {
            $this->handleError("Commande non trouvée.", 'user-zone');
        }
    }
    
    // Rediriger vers la page de confirmation de commande
    private function redirectToOrderConfirmation(int $order_id): void
    {
        try {
            // Récupérer la commande
            $order = $this->om->getOrderById($order_id);
            
            // Récupérer les articles de la commande
            $items = $this->om->getOrderItemsByOrderId($order_id);
            
            // Calculer le total
            $total = array_reduce($items, function ($carry, $item) {
                return $carry + $item->getTotalPrice();
            }, 0);
            
            // Rendre le template avec les détails de la commande
            $this->render('confirmation.html.twig', [
                'cartItems' => $items,
                'cartTotal' => $total,
                'orderId' => $order->getOrder_id(),
                'orderDate' => $order->getDate_order()->format('Y-m-d H:i:s'),
            ]);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération de la commande : " . $e->getMessage());
            $this->handleError("Erreur lors de la récupération de la commande.", 'user-zone');
        }
    }
    
    // Gestion centralisée des erreurs
    private function handleError(string $message, string $route): void
    {
        $_SESSION['error_message'] = $message;
        header("Location: index.php?route=$route");
        exit();
    }
}
