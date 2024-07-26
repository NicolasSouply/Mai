<?php

class Router 
{
    private SiteController $sc;
    private AuthController $ac;
    private DisheController $dc;
    private RegisterController $rc; 

    public function __construct()
    {
        $this->sc = new SiteController();
        $this->ac = new AuthController();
        $this->dc = new DisheController();
        $this->rc = new RegisterController(); 
    }

    public function handleRequest(array $get) : void
    {
        if (isset($get['route'])) {
            switch ($get['route']) {
                case 'home':
                    $this->sc->home();
                    break;
                case 'checkSignUp':
                    $this->rc->register($_POST); 
                    break;
                case 'connexion':
                    $this->sc->connexion();
                    break;
                case 'checkLogin':
                    $loginCorrect = $this->ac->checkLogin($_POST);
                    if ($loginCorrect !== null) {
                        $_SESSION["client"] = $loginCorrect;
                        $this->ac->redirect("index.php?route=client-zone"); 
                    } else {
                        $this->ac->redirect("index.php?route=connexion&error=4"); 
                    }
                    break;

                    case 'logout':
                        $this->ac->logout(); 
                    break;

                case 'register':
                    $this->sc->register();
                    break;

                case 'client-zone':
                    $this->sc->clientZone();
                    break;

                case 'card':
                    $this->sc->card();
                    break;

                case 'about':
                    $this->sc->about();
                    break;

                case 'localisation':
                    $this->sc->localisation();
                    break;

                case 'contact':
                    $this->sc->contact();
                    break;

                case 'reservation':
                    $this->sc->reservation();
                    break;

                case 'addDishe':
                    $this->dc->addDishe(); 

                default:
                    $this->sc->notFound();
                    break;
            }
        } else {
            $this->sc->home();
        }
    }
}