<?php


class SiteController extends AbstractController
{
  public function __construct()
    {
        parent::__construct();

    }

    public function card(): void
{
    $this->render('card.html.twig', []);
}
    public function about(): void
    {
        $this->render('about.html.twig', []);
    }

    public function localisation(): void
    {
      $this->render('localisation.html.twig', []);
    }
    public function contact(): void
    {
      $this->render('contact.html.twig', []);
    }
    public function reservation(): void
    {
      $this->render('reservation.html.twig', []);
    }

    public function homepage(): void
    {    
        $isUserLoggedIn = isset($_SESSION['user']);
        
    
        $this->render('home.html.twig', ['isUserLoggedIn' => $isUserLoggedIn]);  // modif de deco
    }
  
    public function privacyPolicy(): void
    {
      $this->render('privacy-policy.html.twig', []);
    }
    public function cgv(): void
    {
      $this->render('cgv.html.twig', []);
    }
    public function legalsMentions(): void
    {
      $this->render('legals-mentions.html.twig', []);
    }
      public function notFound() : void
      {
          $this->render('error404.html.twig', []);
      }
  }