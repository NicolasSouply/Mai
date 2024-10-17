<?php

class AdminController extends AbstractController
{
    private AdminManager $am;
    private DisheManager $dm;
    private UserManager $um;

    public function __construct()
    {
        parent::__construct();
        $this->am = new AdminManager();
        $this->dm = new DisheManager();
        $this->um = new UserManager();
    }

    public function home(): void
    {
        $this->render('admin/home.html.twig', []);
    }

    public function login(): void
    {
        $this->render('admin/login.html.twig', []);
    }

    public function adminZone(): void
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof Users) {
            $user = $_SESSION['user'];
    
            // Vérifie si l'utilisateur a le rôle "ADMIN"
            if ($user->getRole() === 'ADMIN') {
                // Affiche la page admin
                $this->render('admin/home.html.twig', [
                    'user' => $user
                ]);
            } else {
                // Redirige vers la zone utilisateur si l'utilisateur n'est pas admin
                $_SESSION['error_message'] = "Accès refusé.";
                header('Location: index.php?route=user-zone');
                exit();
            }
        } else {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            $_SESSION['error_message'] = "Pour accéder à cette page, vous devez vous connecter.";
            header('Location: index.php?route=admin-connexion');
            exit();
        }
    }

    public function checkLogin(): void
    {
        // Nettoyage des messages d'erreur et de succès
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }
    
        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
    
        // Vérifie si les données nécessaires sont présentes
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csrf_token'])) {
            // Encode les champs d'entrée pour se protéger contre les attaques XSS
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            
            $tm = new CSRFTokenManager();
    
            // Validation du jeton CSRF
            if ($tm->validateCSRFToken($_POST['csrf_token'])) {
                $user = $this->um->findUserByEmail($email);
    
                // Vérification de l'utilisateur
                if ($user !== null) {
                    // Vérification du mot de passe
                    if (password_verify($password, $user->getPassword())) {
                        $_SESSION['user'] = $user;
    
                        // Redirection selon le rôle de l'utilisateur
                        if ($user->getRole() === 'ADMIN') {
                            $this->redirect('admin-zone'); // Redirection vers la zone admin
                        } else {
                            $this->redirect('user-zone'); // Redirection pour les utilisateurs normaux
                        }
                        
                        exit(); // Assure que le script s'arrête après la redirection
                    } else {
                        $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                        $this->redirect('admin-connexion');
                    }
                } else {
                    $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                    $this->redirect('admin-connexion');
                }
            } else {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('admin-connexion');
            }
        } else {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect('admin-connexion');
        }
    }
}
