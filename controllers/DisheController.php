<?php


class DisheController extends AbstractController
{
    private DisheManager $dm;
      public function __construct()
      {
        parent::__construct();
        $this->dm = new DisheManager();
      }

public function showDishesByCategory()
    {
      $dishes = $this->dm->findAll();
      $this->render('card.html.twig', ['dishes' => $dishes]);
    }
  
}