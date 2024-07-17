<?php


class SiteController extends AbstractController
{
    public function home() : void
    {
      
        $cm = new ClientManager();
        $om = new OrderManager();
        $dom = new DetailOrderManager();
        $dm = new DisheManager();
        $rm = new ReservationManager();

        $clients = $cm->findAll();
        $orders = $om->findAll();
        $detailOrders = $dom->findAll();
        $dishes = $dm->findAll();
        $reservations = $rm->findAll();
        
        $this->render("home.html.twig", [
          "clients" => $clients,
          "orders" => $orders,
          "detailOrders" => $detailOrders,
          "dishes" => $dishes,
          "reservations" => $reservations,
        ]);        
    }
    public function about(): void
    {
        $this->render('about.html.twig', []);
    }
    public function notFound(): void
    {
        $this->render('404.html.twig', []);
    }
    
    public function localisation(): void
    {
      $this->render('localisation.html.twig', []);
    }
    public function card(): void
    {

      $this->render('card.html.twig', []);
    }

    public function contact(): void
    {
      $this->render('contact.html.twig', []);
    }
    public function reservation(): void
    {
      $this->render('reservation.html.twig', []);
    }
   

  }