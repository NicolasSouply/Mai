<?php

class AuthController extends AbstractController
{
    private UserManager $um;
    private AdminManager $am;
    private CSRFTokenManager $ct;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->am = new AdminManager();
        $this->ct = new CSRFTokenManager();
    }



    public function checkLogin(array $post): ?Users
    {
        if (!isset($post["email"], $post["password"])) {
            $this->redirectWithError('index.php?route=connexion', 'Email et mot de passe sont obligatoires.');
            return null;
        }

        if (empty($post['csrf-token']) || !$this->ct->validateCSRFToken($post['csrf-token'])) {
            $this->redirectWithError('index.php?route=connexion', 'Token CSRF invalide.');
            return null;
        }

        $user = $this->um->findUserByEmail($post["email"]);

        if ($user === null) {
            $this->redirectWithError('index.php?route=connexion', 'Email non trouvé.');
            return null;
        }

        if (!password_verify($post["password"], $user->getPassword())) {
            $this->redirectWithError('index.php?route=connexion', 'Mot de passe incorrect.');
            return null;
        }

        $_SESSION["user"] = $user;

        if ($this->am->isAdmin($post["email"])) {
            $_SESSION["admin"] = $user;
            $this->redirect("admin-zone.html.twig");
        } else {
            $this->redirect("index.php?route=user-zone&user-id=" . $user->getId());
        }

        return $user;
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
            $existingUser = $this->um->findUserByEmail($post["email"]);
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

            if ($this->um->createUser($user)) {
                $_SESSION["user"] = $user;
                $this->redirect("index.php?route=user-zone");
            } else {
                $this->redirect("index.php?route=register&error=5"); // Erreur d'enregistrement
            }
        } else {
            $this->redirect("index.php?route=register&error=1");  // Erreur: Données manquantes
        }
    }
    public function checkRegister() : void
    {
        if (!isset($_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['csrf_token'])) {
            $this->redirectWithError('index.php?route=inscription', 'Tous les champs sont obligatoires.');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        $csrfToken = $_POST['csrf_token'];
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $role = $_POST['role'] ?? 'USER'; 

        if (!$this->ct->validateCSRFToken($csrfToken)) {
            $this->redirectWithError('index.php?route=inscription', 'Token CSRF invalide.');
            return;
        }

        if ($this->um->findUserByEmail($email)) {
            $this->redirectWithError('index.php?route=inscription', 'Un compte avec cet email existe déjà.');
            return;
        }

        if ($password !== $confirmPassword) {
            $this->redirectWithError('index.php?route=inscription', 'Les mots de passe ne correspondent pas.');
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user = new Users($firstName, $lastName, $email, $phone, $hashedPassword, $role);

        $this->um->createUser($user);

        $this->redirect('index.php?route=connexion');
    }

    


    private function redirectWithError(string $url, string $errorMessage) : void {
        // Stocker le message d'erreur dans la session pour l'afficher après la redirection
        $_SESSION['error'] = $errorMessage;
        header("Location: $url");
        exit();
    }
}
