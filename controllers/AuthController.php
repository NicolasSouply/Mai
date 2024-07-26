<?php

class AuthController extends AbstractController
{
    private ClientManager $cm;

    public function __construct()
    {
        parent::__construct();
        $this->cm = new ClientManager();
    }

    public function checkLogin(array $post): ?Clients
    {

        if (isset($post["email"]) && isset($post["password"])) {
            $client = $this->cm->findByEmail($post["email"]);
            $csrft = new CSRFTokenManager();
    

            if (!empty($post['csrf-token']) && $csrft->validateCSRFToken($post['csrf-token'])) {
                if ($client !== null) {
                    $password = $post["password"];
                    $passwordCorrect = password_verify($password, $client->getPassword());
                    if ($passwordCorrect) {
                        $_SESSION["client"] = $client;
                        $this->redirect("index.php?route=client-zone&client-id=" . $client->getId());
                        return $client; 
                    } else {
                        $this->redirect("index.php?route=connexion&error=1"); 
                    }
                } else {
                    $this->redirect("index.php?route=connexion&error=2"); 
                }
            } else {

                $this->redirect("index.php?route=connexion&error=3"); 
            }
        } else {
     
            $this->redirect("index.php?route=connexion&error=4"); 
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