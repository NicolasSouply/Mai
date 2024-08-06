<?php

class RegisterController extends AbstractController
{
    private UserManager $um;
    private CSRFTokenManager $ct;
    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
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
            $existingUser = $this->um->findByEmail($post["email"]);
            if ($existingUser !== null) {
                $this->redirect("index.php?route=register&error=6"); // Erreur: Email déjà utilisé
                return;
            }

            $user= new Users(
                $post["firstName"],
                $post["lastName"],
                $post["email"],
                $post["phone"],
                password_hash($post["password"], PASSWORD_DEFAULT),
                $post["role"]
            );

            if ($this->um->create($user)) {
                $_SESSION["user"] = $user;
                $this->redirect("index.php?route=user-zone");
            } else {
                $this->redirect("index.php?route=register&error=5"); // Erreur d'enregistrement
            }
        } else {
            $this->redirect("index.php?route=register&error=1");  // Erreur: Données manquantes
        }
    }
    
}
