<?php

class AuthController extends AbstractController
{
    private UserManager $um;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
    }

    public function register(): void
    { 
        $this->render('register.html.twig', []);
    }

    public function checkRegister(): void
{
    // Réinitialisation des messages d'erreur et de succès
    unset($_SESSION['error_message'], $_SESSION['success_message']);
    
    // Vérification des champs requis
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['confirm_password'], $_POST['csrf_token'])) {
        // Protection contre les failles XSS
        $firstName = htmlspecialchars($_POST['first_name']);
        $lastName = htmlspecialchars($_POST['last_name']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $password = htmlspecialchars($_POST['password']);
        $confirmPassword = htmlspecialchars($_POST['confirm_password']);
        
        // Validation du token CSRF
        $tm = new CSRFTokenManager();
        if (!$tm->validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
            $this->redirect('inscription');
            return;
        }

        // Vérification de l'unicité de l'email
        $user = $this->um->findUserByEmail($email);
        if ($user !== null) {
            $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse email.";
            $this->redirect('inscription');
            return;
        }

        // Définition du regex pour le mot de passe
        $passwordRegex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

        // Validation du mot de passe
        if (!preg_match($passwordRegex, $password)) {
            $_SESSION['error_message'] = "Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.";
            $this->redirect('inscription');
            return;
        }

        // Vérification de la correspondance des mots de passe
        if ($password !== $confirmPassword) {
            $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
            $this->redirect('inscription');
            return;
        }

        // Hashage du mot de passe et création de l'utilisateur
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user = new Users($firstName, $lastName, $email, $phone, $hashedPassword, "USER");

        // Tentative de création de l'utilisateur
        try {
            $this->um->createUser($user);
            $_SESSION['success_message'] = "Votre compte a bien été créé";
            $this->redirect('connexion');
        } catch (\Exception $e) {
            $_SESSION['error_message'] = "Erreur lors de la création du compte. Veuillez réessayer.";
            $this->redirect('inscription');
        }
    } else {
        $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
        $this->redirect('inscription');
    }
}


    public function login(): void
    {
        $this->render('login.html.twig', []);
    }

    public function checkLogin(): void
    {
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }

        if (isset($_POST['email'], $_POST['password'], $_POST['csrf_token'])) {
            // Encode user input to protect against XSS
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            
            $tm = new CSRFTokenManager();

            if ($tm->validateCSRFToken($_POST['csrf_token'])) {

                $user = $this->um->findUserByEmail($email);

                if ($user !== null) {
                    if (password_verify($password, $user->getPassword())) {
                        $_SESSION['user'] = $user;

                        // Redirect based on user role
                        if ($user->getRole() === 'ADMIN') {
                            $this->redirect('admin-zone');
                        } else {
                            $this->redirect('user-zone');
                        }
                        exit();
                    } else {
                        $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                        $this->redirect('connexion');  
                    }
                } else {
                    $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                    $this->redirect('connexion'); 
                }
            } else {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('connexion');  
            }
        } else {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect('connexion');  
        }
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('home');
        exit;
    }
}
