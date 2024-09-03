<?php


class SiteController extends AbstractController
{
  public function __construct()
    {
        parent::__construct();

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

      public function homepage() : void
      {
          $this->render('home.html.twig', []);
      }
  
      public function notFound() : void
      {
          $this->render('error404.html.twig', []);
      }
  }