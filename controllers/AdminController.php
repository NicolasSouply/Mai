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
        //var_dump("AdminController::home() called"); // Vérifie si la méthode est bien appelée

        $this->render('admin/home.html.twig', []);
    }
    public function login() : void {
        $this->render('admin/login.html.twig', []);
    }

    public function adminZone(): void
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof Users) {
            $user = $_SESSION['user'];
    
            // Vérifie si l'utilisateur a le rôle "ADMIN"
            if ($user->getRole() === 'ADMIN') {
                // Debug: Vérifie les données de l'utilisateur admin
                //var_dump($user);
    
                // Affiche la page admin
                $this->render('admin/home.html.twig', [
                    'user' => $user
                ]);
            } else {
                // Si l'utilisateur n'est pas admin, redirige vers la zone utilisateur
                $_SESSION['error_message'] = "Accès refusé.";
                header('Location: index.php?route=user-zone');
                exit();
            }
        } else {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            $_SESSION['error_message'] = "Vous devez être connecté pour accéder à cette page.";
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
            $tm = new CSRFTokenManager();
    
            // Validation du jeton CSRF
            if ($tm->validateCSRFToken($_POST['csrf_token'])) {
                $user = $this->um->findUserByEmail($_POST['email']);
    
                // Vérification de l'utilisateur
                if ($user !== null) {
                    // Vérification du mot de passe
                    if (password_verify($_POST['password'], $user->getPassword())) {
                        $_SESSION['user'] = $user;
    
                        // Redirection selon le rôle de l'utilisateur
                        if ($user->getRole() === 'ADMIN') {
                            $this->redirect('admin-zone'); // Assure-toi que 'admin-zone' est la route correcte pour les admins
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