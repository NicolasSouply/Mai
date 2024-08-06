<?php

class userController extends AbstractController
{
    private UserManager $um;
    private OrderManager $om;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->om = new OrderManager(); 
    }

    public function userZone(): void
    {
     
        if (!isset($_SESSION["user"])) {
            $this->redirect("index.php?route=connexion"); 
            return;
        }

 
        $user = $_SESSION["user"];


        $orders = $this->om->findOrdersByuserId($user->getId());

        // Passer les données au template
        $this->render('user-zone.html.twig', [
            'orders' => $orders,
            'euros' => '€'
        ]);
    }
    public function findByEmail(string $email): ?Users
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM users
            WHERE email = :email"
        );
        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);
    
        if ($query->rowCount() === 1) {
            $user = $query->fetch(PDO::FETCH_ASSOC);
            
            if (isset($user["id"], $user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"])) {
                $userClass = new Users($user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"]);
                $userClass->setId($user["id"]);
                return $userClass;
            } else {
                return null; 
            }
        } else {
            return null;
        }
    }
}