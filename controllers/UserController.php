<?php

class UserController extends AbstractController
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
        $orders = $this->om->findOrdersByUserId($user->getId());

        $this->render('user-zone.html.twig', [
            'orders' => $orders,
            'euros' => '€'
        ]);
    }

    public function reserveTable(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('index.php?route=connexion');
        } else {
            $this->render('reserve.html.twig', [
                'csrf_token' => $this->generateAndStoreCSRFToken()
            ]);
        }
    }
}
