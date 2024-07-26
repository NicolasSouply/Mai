<?php

class RegisterController extends AbstractController
{
    private ClientManager $cm;
    private CSRFTokenManager $ct;
    public function __construct()
    {
        parent::__construct();
        $this->cm = new ClientManager();
        $this->ct = new CSRFTokenManager();
    }

    public function register(array $post): void
    {
        var_dump($post);
        
        if (!$this->ct->validateCSRFToken($post['csrf-token'])) {
            $this->redirect("index.php?route=register&error=3"); // Erreur de validation CSRF
            return;
        }

        if (isset($post["email"]) && isset($post["password"]) && 
        isset($post["firstName"]) && isset($post["lastName"]) && 
        isset($post["phone"])) 
        {
            $existingClient = $this->cm->findByEmail($post["email"]);
            if ($existingClient !== null) {
                $this->redirect("index.php?route=register&error=6"); // Erreur: Email déjà utilisé
                return;
            }

            $client = new Clients(
                $post["firstName"],
                $post["lastName"],
                $post["email"],
                $post["phone"],
                password_hash($post["password"], PASSWORD_DEFAULT)
            );

            if ($this->cm->create($client)) {
                $_SESSION["client"] = $client;
                $this->redirect("index.php?route=client-zone");
            } else {
                $this->redirect("index.php?route=register&error=5"); // Erreur d'enregistrement
            }
        } else {
            $this->redirect("index.php?route=register&error=1");  // Erreur: Données manquantes
        }
    }
    
}
