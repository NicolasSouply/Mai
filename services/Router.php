<?php

class Router 
{
  private SiteController $sc;

  public function __construct()
  {
    $this->sc = new SiteController();
  }
  public function handleRequest(array $get) : void
  
  {

    if(isset($get['route']) && $get['route'] === 'home')
    {
      $this->sc->home();
    }
    else if(isset($get['route']) && $get['route'] === 'card')
    {
      $this->sc->card();
    }
  
    else if(isset($get['route']) && $get['route'] === 'about')
    {
      $this->sc->about();
    }
   
    else if(isset($get['route']) && $get['route'] === 'localisation')
    {
      $this->sc->localisation();
    }

    else if(isset($get['route']) && $get['route'] === 'contact')
    {
      $this->sc->contact();
    }

    else if(isset($get['route']) && $get['route'] === 'reservation')
    {
      $this->sc->reservation();
    }
    
  

    else if(!isset($get["route"]))
    {
      $this->sc->home();
    }
        else
    {
      $this->sc->notFound();
    } 
  
  }
}