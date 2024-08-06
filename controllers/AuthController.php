<?php

class AuthController extends AbstractController
{
    private UserManager $um;
    private AdminManager $am;
    private CSRFTokenManager $csrft;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->am = new AdminManager();
        $this->csrft = new CSRFTokenManager();
    }

    public function checkLogin(array $post): ?Users
    {
        if (isset($post["email"]) && isset($post["password"])) {
            if (!empty($post['csrf-token']) && $this->csrft->validateCSRFToken($post['csrf-token'])) {
                $user = $this->um->findByEmail($post["email"]);
                
                if ($user !== null) {
                    $passwordCorrect = password_verify($post["password"], $user->getPassword());
                    
                    if ($passwordCorrect) {
                        $_SESSION["user"] = $user;
                        
                        if ($this->am->isAdmin($post["email"])) { //vérif si le user est un admin 
                            $_SESSION["admin"] = $user;
                            $this->redirect("admin-zone.html.twig");
                        } else {
                            $this->redirect("index.php?route=user-zone&user-id=" . $user->getId());
                        }
                        
                        return $user;
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
