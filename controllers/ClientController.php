<?php

class ClientController extends AbstractController
{
    private ClientManager $cm;
    private OrderManager $om;

    public function __construct()
    {
        parent::__construct();
        $this->cm = new ClientManager();
        $this->om = new OrderManager(); 
    }

    public function clientZone(): void
    {
     
        if (!isset($_SESSION["client"])) {
            $this->redirect("index.php?route=connexion"); 
            return;
        }

 
        $client = $_SESSION["client"];


        $orders = $this->om->findOrdersByClientId($client->getId());

        // Passer les données au template
        $this->render('client-zone.html.twig', [
            'orders' => $orders,
            'euros' => '€'
        ]);
    }
}