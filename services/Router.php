<?php 

class Router 
{ 
    private SiteController $sc;
    private AuthController $ac;
    private DisheController $dc;
    private AdminController $adc;
    private UserController $uc;
    
    public function __construct()
    {
        $this->sc = new SiteController();
        $this->ac = new AuthController();
        $this->dc = new DisheController();
        $this->adc = new AdminController(); 
        $this->uc = new UserController();

        //var_dump($this->ac);
    }
    private function checkAdmin(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']->getRole() !== 'ADMIN') {
            header('Location: index.php?route=admin-connexion');
            exit(); 
        }
    }
    

    public function handleRequest(? string $route) : void
    {
        if ($route === null || $route === 'home')  
        {
        var_dump($route); 
            // le code si il n'y a pas de route ( === la page d'accueil)
            $this->sc->homepage(); 
        }
        elseif ($route === 'inscription') 
        {
            $this->ac->register();
        } 
        else if($route === "check-inscription")
        {
            $this->ac->checkRegister();
        }
        else if($route === "connexion")
        {
            //var_dump('start');
            $this->ac->login();
        }
        else if($route === "check-connexion")
        {
            $this->ac->checkLogin();
        }
        else if($route === "deconnexion")
        {
            $this->ac->logout();
        }
        else if ($route === 'user-zone')
        {
            $this->uc->userZone();
        }
        else if($route === "admin-zone")
        {        var_dump('Route: admin-zone'); // Vérifie que la route admin est bien appelée

            $this->checkAdmin();
            $this->adc->adminZone();
        }
        else if($route === "admin-connexion")
        {
            $this->adc->login();
        }
        else if($route === "admin-check-connexion")
        {
            $this->adc->checkLogin();
        }
        else if($route === "admin-create-user")
        {
            $this->checkAdmin();
            $this->uc->create();
        }
        else if($route === "admin-check-create-user")
        {
            $this->checkAdmin();
            $this->uc->checkCreate();
        }
        else if($route === "admin-edit-user" && isset($_GET["user_id"]))
        {
            $this->checkAdmin();
            $this->uc->edit(intval($_GET["user_id"]));
        }
        else if($route === "admin-check-edit-user" && isset($_GET["user_id"]))
        {
            $this->checkAdmin();
            $this->uc->checkEdit(intval($_GET["user_id"]));
        }
        else if($route === "admin-delete-user" && isset($_GET["user_id"]))
        {
            $this->checkAdmin();
            $this->uc->delete(intval($_GET["user_id"]));
        }
        else if($route === "admin-list-users")
        {
            $this->checkAdmin();
            $this->uc->list();
        }
        // Routes pour la gestion des plats
    else if($route === "admin-listDishes")
    {
        $this->checkAdmin();
        $this->dc->listDishes();
    }
    else if($route === "admin-addDishe")
    {
        $this->checkAdmin();
        $this->dc->addDishe();
    }
    else if($route === "admin-check-addDishe")
    {
        $this->checkAdmin();
        $this->dc->checkAddDishe();
    }
    else if($route === "admin-editDishe" && isset($_GET["dishe_id"]))
    {
        $this->checkAdmin();
        $this->dc->editDishe(intval($_GET["dishe_id"]));
    }
    else if ($route === "admin-check-editDishe" && isset($_GET["dishe_id"]))
    {
        $this->checkAdmin();
        $this->dc->checkEditDishe(intval($_GET["dishe_id"]));
    }
    
    else if($route === "admin-deleteDishe" && isset($_GET["dishe_id"]))
    {
        $this->checkAdmin();
        $this->dc->deleteDishe(intval($_GET["dishe_id"]));
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
        else if($route === "admin-show-user" && isset($_GET["user_id"]))
        {
            $this->checkAdmin();
            $this->uc->show(intval($_GET["user_id"]));
        }
        else {
            var_dump('Route non trouvée : ' . $route); // Vérifie si la route est inconnue

            $this->sc->notFound();
        }
    }
}
