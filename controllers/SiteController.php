<?php


class SiteController extends AbstractController
{
  private ClientManager $cm;
  private OrderManager $om;
  private DetailOrderManager $dom;
  private DisheManager $dm;
  private ReservationManager $rm;
  public function __construct()
    {
        parent::__construct();
        $this->cm = new ClientManager();
        $this->om = new OrderManager();
        $this->dom = new DetailOrderManager();
        $this->dm = new DisheManager();
        $this->rm = new ReservationManager();
    }
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
    public function connexion():void{
      $this->render("connexion.html.twig", ['csrf_token'=>$_SESSION['csrf_token']]);
  }
  public function register():void{
    $this->render("register.html.twig", ['csrf_token'=>$_SESSION['csrf_token']]);
}
public function someAction()
{
    $isUserLoggedIn = isset($_SESSION['client']);
    $this->render('layout.twig', ['isUserLoggedIn' => $isUserLoggedIn]);
}
public function clientZone()
    {
        if (!isset($_SESSION["client"])) {
            $this->redirect("index.php?route=connexion");
        } else {
            $this->render('client-zone.html.twig', ['client' => $_SESSION["client"]]);
        }
    }
public function logout():void{
  session_destroy();
  $this->redirect("index.php?route=home");
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