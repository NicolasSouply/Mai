<?php

class AuthController extends AbstractController
{
    private ClientManager $cm;
    private CSRFTokenManager $csrft;

    public function __construct()
    {
        parent::__construct();
        $this->cm = new ClientManager();
        $this->csrft = new CSRFTokenManager();
    }

    public function checkLogin(array $post): ?Clients
    {
        if (isset($post["email"]) && isset($post["password"])) {
            if (!empty($post['csrf-token']) && $this->csrft->validateCSRFToken($post['csrf-token'])) {
                $client = $this->cm->findByEmail($post["email"]);
                
                if ($client !== null) {
                    $passwordCorrect = password_verify($post["password"], $client->getPassword());
                    
                    if ($passwordCorrect) {
                        $_SESSION["client"] = $client;
                        $this->redirect("index.php?route=client-zone&client-id=" . $client->getId());
                        return $client;
                    } else {
                        $this->redirect("index.php?route=connexion&error=1"); // Mot de passe incorrect
                    }
                } else {
                    $this->redirect("index.php?route=connexion&error=2"); // Email non trouvé
                }
            } else {
                $this->redirect("index.php?route=connexion&error=3"); // Erreur de validation CSRF
            }
        } else {
            $this->redirect("index.php?route=connexion&error=4"); // Données manquantes
        }
        
        return null;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect("index.php?route=home");
    }
}
