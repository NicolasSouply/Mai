<?php 

class Router 
{ 
    private SiteController $sc;
    private AuthController $ac;
    private DisheController $dc;
    private AdminController $adc;
    
    public function __construct()
    {
        $this->sc = new SiteController();
        $this->ac = new AuthController();
        $this->dc = new DisheController();
        $this->adc = new AdminController(); 
    }

    public function handleRequest(?array $get) : void
    {
        if (isset($get['route'])) {
            $route = $get['route'];
        
            if ($route === 'home') 
            {
                $this->sc->home();
            } 
            elseif ($route === 'checkSignUp') 
            {
                $this->ac->register($_POST);
            } 
            elseif ($route === 'connexion') 
            {
                $this->ac->login();
            } 
            elseif ($route === 'checkLogin') 
            {echo "<script>alert('tata');</script>";
                $this->ac->checkLogin();
            } 
            elseif ($route === 'admin-zone') 
            {
                $this->adc->adminZone();
            } 
            elseif ($route === 'logout') 
            {
                $this->sc->logout();
            } 
            elseif ($route === 'register') 
            {
                $this->sc->register();
            } 
            elseif ($route === 'user-zone') 
            {
                $this->sc->userZone();
            } 
            elseif ($route === 'card') 
            {
                $this->sc->card();
            } 
            elseif ($route === 'about') 
            {
                $this->sc->about();
            } 
            elseif ($route === 'localisation') 
            {
                $this->sc->localisation();
            } 
            elseif ($route === 'contact') 
            {
                $this->sc->contact();
            } 
            elseif ($route === 'reservation') 
            {
                $this->sc->reservation();
            } 
            elseif ($route === 'addDishe') {
                $this->dc->addDishe();
            } 
            else {
                $this->sc->notFound();
            }
        } else {
            $this->sc->home();
        }
    }

}
