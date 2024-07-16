<?php


class AdminController extends AbstractController
{
    

public function admin(): void
    {
      $this->render('admin_zone.html.twig', []);
    }
  
}