<?php


class SiteController extends AbstractController
{
  private UserManager $um;
  private OrderManager $om;
  private DetailOrderManager $dom;
  private DisheManager $dm;
  private ReservationManager $rm;
  public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->om = new OrderManager();
        $this->dom = new DetailOrderManager();
        $this->dm = new DisheManager();
        $this->rm = new ReservationManager();
    }
    public function home() : void
    {
      
        $um = new UserManager();
        $om = new OrderManager();
        $dom = new DetailOrderManager();
        $dm = new DisheManager();
        $rm = new ReservationManager();

        $users = $um->findAll();
        $orders = $om->findAll();
        $detailOrders = $dom->findAll();
        $dishes = $dm->findAll();
        $reservations = $rm->findAll();
        
        $this->render("home.html.twig", [
          "users" => $users,
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
        $isUserLoggedIn = isset($_SESSION['user']);
        $this->render('layout.twig', ['isUserLoggedIn' => $isUserLoggedIn]);
    }
    public function userZone()
        {
        if (!isset($_SESSION["user"])) {
            $this->redirect("index.php?route=connexion");
        } else {
            $this->render('user-zone.html.twig', ['user' => $_SESSION["user"]]);
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