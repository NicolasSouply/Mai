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
;
            $this->redirectWithError("index.php?route=register", 'error_csrf');
            return;
        }
    
        if ($this->isValidRegistration($post)) {
            $user = new Users(
                $post["first_name"],
                $post["last_name"],
                $post["email"],
                $post["phone"],
                $post["password"],
                'user'
            );

    
            if ($this->um->createUser($user)) {
                $_SESSION["user"] = $user;
                $this->redirect("index.php?route=user-zone");
            } else {
                // Debugging: Échec de la création de l'utilisateur
                var_dump("Erreur : Impossible de créer l'utilisateur.");
                $this->redirectWithError("index.php?route=register", 'error_create');
            }
        } else {
            // Debugging: Validation de l'inscription échouée
            var_dump("Erreur : Validation de l'inscription échouée.");
            $this->redirectWithError("index.php?route=register", 'error_missing');
        }
    }

    public function checkRegister(): void
    {
        // Nettoyer les messages de session précédents
        $this->clearSessionMessages();

        // Vérifier que la requête est de type POST et que tous les champs nécessaires sont présents
        var_dump("Méthode de la requête : " . ($_SERVER['REQUEST_METHOD'] ?? 'Aucune'));

        if ($this->isPostRequest() && isset($_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['csrf_token'])) {
            // Afficher les données POST pour débogage
            var_dump("Champs POST reçus : ", $_POST);

            // Initialiser le gestionnaire de jetons CSRF
            $tm = new CSRFTokenManager();

            // Valider le jeton CSRF
            if ($tm->validateCSRFToken($_POST['csrf_token'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // Vérifier que les champs ne sont pas vides
                if (empty($email) || empty($password) || empty($confirm_password)) {
                    var_dump("Erreur : Champs vides détectés.");
                    $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
                    $this->redirect('register');
                    return;
                }

                // Rechercher l'utilisateur par email
                $user = $this->um->findUserByEmail($email);
                var_dump("Utilisateur trouvé : ", $user);

                if ($user) {
                    // Utilisateur existe déjà
                    var_dump("Erreur : Un compte existe déjà avec cette adresse.");
                    $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse.";
                    $this->redirect('register');
                } elseif ($password !== $confirm_password) {
                    // Les mots de passe ne correspondent pas
                    var_dump("Erreur : Les mots de passe ne correspondent pas.");
                    $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                    $this->redirect('register');
                } else {
                    // Créer un nouvel utilisateur
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $user = new Users(
                        $_POST['first_name'] ?? '',
                        $_POST['last_name'] ?? '',
                        $email,
                        $_POST['phone'] ?? '',
                        $hashedPassword,
                        'user'
                    );

                    try {
                        // Enregistrer l'utilisateur dans la base de données
                        $this->um->createUser($user);
                        $_SESSION['success_message'] = "Votre compte a bien été créé";
                        $this->redirect('connexion');
                    } catch (\Exception $e) {
                        // Gérer les erreurs de création de l'utilisateur
                        var_dump("Erreur : " . $e->getMessage());
                        $_SESSION['error_message'] = $e->getMessage();
                        $this->redirect('register');
                    }
                }
            } else {
                // Jeton CSRF invalide
                var_dump("Erreur : Le jeton CSRF est invalide.");
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('register');
            }
        } else {
            // Requête non POST ou champs manquants
            var_dump("Erreur : Requête non POST ou champs manquants.");
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
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
        // Nettoyer les messages de session précédents
        $this->clearSessionMessages();

        // Vérifiez la méthode de la requête POST
        var_dump("Méthode de la requête : " . ($_SERVER['REQUEST_METHOD'] ?? 'Aucune'));

        // Vérifiez que tous les champs requis sont présents
        if ($this->isPostRequest() && isset($_POST['email'], $_POST['password'], $_POST['csrf_token'])) {
            var_dump("Champs POST reçus : ", $_POST); // Affichez toutes les données POST reçues

            // Créer une instance de CSRFTokenManager
            $csrfTokenManager = new CSRFTokenManager();
            var_dump("Token CSRF reçu : " . $_POST['csrf_token']);

            // Vérifiez la validité du token CSRF
            $csrfToken = $_POST['csrf_token'];
            $isCsrfValid = $csrfTokenManager->validateCSRFToken($csrfToken);
            var_dump("Token CSRF valide : " . ($isCsrfValid ? 'oui' : 'non'));

            if ($isCsrfValid) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                var_dump("Email reçu : " . $email);
                var_dump("Mot de passe reçu : " . $password);

                // Rechercher l'utilisateur par email
                $user = $this->um->findUserByEmail($email);
                var_dump("Utilisateur trouvé : ", $user); // Affichez l'objet utilisateur trouvé

                // Vérifiez si l'utilisateur existe
                if ($user !== null) {
                    // Vérifiez si le mot de passe est correct
                    $hashedPassword = $user->getPassword();
                    var_dump("Mot de passe stocké : " . $hashedPassword);

                    $isPasswordValid = password_verify($password, $hashedPassword);
                    var_dump("Mot de passe valide : " . ($isPasswordValid ? 'oui' : 'non'));

                    if ($isPasswordValid) {
                        $_SESSION['user'] = $user;
                        var_dump("Utilisateur connecté : ", $_SESSION['user']); // Affichez les détails de l'utilisateur connecté

                        // Redirigez en fonction du rôle de l'utilisateur
                        $role = $user->getRole();
                        var_dump("Rôle de l'utilisateur : " . $role);

                        if ($role === 'admin') {
                            $this->redirect("admin-zone");  // Redirige vers la zone admin
                            var_dump("Redirection vers admin-zone"); // Déboguez la redirection
                        } else {
                            $this->redirect("user-zone");   // Redirige vers la zone utilisateur
                            var_dump("Redirection vers user-zone"); // Déboguez la redirection
                        }
                    } else {
                        $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                        var_dump("Erreur : Identifiant ou mot de passe incorrect.");
                        $this->redirect('connexion&error=1'); // Erreur mot de passe incorrect
                    }
                } else {
                    $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                    var_dump("Erreur : Identifiant ou mot de passe incorrect.");
                    $this->redirect('connexion&error=2'); // Erreur utilisateur non trouvé
                }
            } else {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                var_dump("Erreur : Jeton CSRF invalide.");
                $this->redirect('connexion&error=3'); // Erreur CSRF
            }
        } else {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            var_dump("Erreur : Champs manquants.");
            $this->redirect('connexion&error=4'); // Erreur champs manquants
        }
    }

    private function isValidRegistration(array $post): bool
    {
        var_dump("Validation des données d'inscription : ", $post);
        return !empty($post["email"]) && 
           !empty($post["password"]) && 
           !empty($post["firstName"]) && 
           !empty($post["lastName"]) && 
           !empty($post["phone"]) &&
           ($post["password"] === $post["checkPassword"]);  // Vérifie si les mots de passe correspondent
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
