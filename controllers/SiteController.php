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
      
      $this->render('home.html.twig', []);
    }

    public function register():void
    {
    $this->render("register.html.twig", ['csrf_token'=>$_SESSION['csrf_token']]);
    }
    public function showInscriptionForm() : void
    {
        $this->render('register.html.twig', []);
    }

    public function processInscription() : void
    {

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';


        if ($username && $password) {

            header('Location: index.php?route=connexion');
            exit;
        }

        
        $this->render('register.html.twig', ['error' => 'Veuillez remplir tous les champs.']);
    }

    public function showConnexionForm() : void
    {
        $this->render('connexion.html.twig', []);
    }
    public function someAction()
    {
        $isUserLoggedIn = isset($_SESSION['user']);
        $this->render('layout.twig', ['isUserLoggedIn' => $isUserLoggedIn]);
    }

    public function processConnexion() : void
    {

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username && $password) {

            header('Location: index.php?route=home');
            exit;
        }

     
        $this->render('connexion.html.twig', ['error' => 'Veuillez remplir tous les champs.']);
    }
    public function userZone()
        {
        if (!isset($_SESSION["user"])) {
            $this->redirect("index.php?route=connexion");
        } else {
            $this->render('user-zone.html.twig', ['user' => $_SESSION["user"]]);
        }
    }


  public function processLogout() : void
    {

        header('Location: index.php?route=home');
        exit;
    }
    public function about(): void
    {
        $this->render('about.html.twig', []);
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
   
    public function notFound() : void
    {
        $this->render('error404.html.twig', []);
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect("index.php?route=home");
    }
  }