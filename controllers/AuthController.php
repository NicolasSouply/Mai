<?php

class AuthController extends AbstractController
{
    private UserManager $um;
    private CSRFTokenManager $csrfT;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->csrfT = new CSRFTokenManager(); // Assurez-vous que l'instance est partagée
    }

    public function register(array $post): void
    {
        if (!$this->csrfT->validateCSRFToken($post['csrf_token'])) {
            $this->redirectWithError("index.php?route=register", 'error_csrf');
            return;
        }

        if ($this->isValidRegistration($post)) {
            $user = new Users(
                $post["first_name"],
                $post["last_name"],
                $post["email"],
                $post["phone"],
                password_hash($post["password"], PASSWORD_DEFAULT),
                'user'
            );

            if ($this->um->createUser($user)) {
                $_SESSION["user"] = $user;
                $this->redirect("index.php?route=user-zone");
            } else {
                $this->redirectWithError("index.php?route=register", 'error_create');
            }
        } else {
            $this->redirectWithError("index.php?route=register", 'error_missing');
        }
    }

    public function checkRegister(): void
    {
        $this->clearSessionMessages();

        if ($this->isPostRequest() && isset($_POST['csrf_token']) && $this->csrfT->validateCSRFToken($_POST['csrf_token'])) {
            
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($email) || empty($password) || empty($confirm_password)) {
                $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
                $this->redirect('register');
                return;
            }

            $user = $this->um->findUserByEmail($email);

            if ($user) {
                $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse.";
                $this->redirect('register');
            } elseif ($password !== $confirm_password) {
                $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                $this->redirect('register');
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $user = new Users(
                    $_POST['first_name'],
                    $_POST['last_name'],
                    $email,
                    $_POST['phone'],
                    $hashedPassword,
                    'user'
                );

                try {
                    $this->um->createUser($user);
                    $_SESSION['success_message'] = "Votre compte a bien été créé";
                    $this->redirect('connexion');
                } catch (\Exception $e) {
                    $_SESSION['error_message'] = $e->getMessage();
                    $this->redirect('register');
                }
            }
        } else {
            $_SESSION['error_message'] = "Le jeton CSRF est invalide ou la méthode de requête est incorrecte.";
            $this->redirect('register');
        }
    }

    public function login(): void
    {
        $this->render('login.html.twig', [
            'csrf_token' => $this->generateAndStoreCSRFToken()
        ]);
    }

    public function checkLogin(): void
    {
        // Réinitialiser les messages d'erreur et de succès
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }
    
        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
    
        // Vérifier que tous les champs requis sont présents
        if (isset($_POST['email'], $_POST['password'], $_POST['csrf_token'])) {
            // Créer une instance de CSRFTokenManager
            $csrfTokenManager = new CSRFTokenManager();
    
            // Vérifier la validité du token CSRF
            if ($csrfTokenManager->validateCSRFToken($_POST['csrf_token'])) {
                // Trouver l'utilisateur par email
                $user = $this->um->findUserByEmail($_POST['email']);
    
                if ($user !== null) {
                    // Vérifier si le mot de passe est correct
                    if (password_verify($_POST['password'], $user->getPassword())) {
                        $_SESSION['user'] = $user;
    
                        // Rediriger en fonction du rôle de l'utilisateur
                        if ($user->getRole() === 'admin') {
                            $this->redirect("admin-zone");
                        } else {
                            $this->redirect("user-zone");
                        }
                    } else {
                        $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                        $this->redirect('connexion&error=1');
                    }
                } else {
                    $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                    $this->redirect('connexion&error=1');
                }
            } else {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('connexion&error=3');
            }
        } else {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect('connexion&error=4');
        }
    }
    

    private function isValidRegistration(array $post): bool
    {
        return !empty($post["email"]) && !empty($post["password"]) && !empty($post["first_name"]) && !empty($post["last_name"]) && !empty($post["phone"]);
    }

    private function isPostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    private function clearSessionMessages(): void
    {
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
    }
    
    public function logout() : void
    {
        session_destroy();
        $this->redirect(null);
    }
}
