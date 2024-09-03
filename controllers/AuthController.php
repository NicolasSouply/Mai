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
    // Debugging:
    var_dump('commencement de checkRegister');
    
    // Clear previous messages
    if (isset($_SESSION['error_message'])) {
        unset($_SESSION['error_message']);
        var_dump('étape 2 : Session error_message ');
    }

    if (isset($_SESSION['success_message'])) {
        unset($_SESSION['success_message']);
    }

    // Check for all required POST fields
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['csrf_token'])) {
        var_dump('Tous les fichiers sont présents');

        // Validate CSRF token
        $tm = new CSRFTokenManager();
        if ($tm->validateCSRFToken($_POST['csrf_token'])) {
            var_dump('CSRF token valide');

            $user = $this->um->findUserByEmail($_POST['email']);
            var_dump($user);

            if ($user === null) {
                var_dump('Pas user trouvé avec cet email');

                if ($_POST['password'] === $_POST['confirm_password']) {
                    var_dump('les passwords match');

                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    $user = new Users($_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['email'], $password, "USER");
                    var_dump($user);

                    try {
                        var_dump('essaye de créer un user');

                        $this->um->createUser($user);
                        var_dump('User créé  ok');
                        $_SESSION['success_message'] = "Votre compte a bien été créé";
                        $this->redirect('connexion');
                    } 
                    catch (\Exception $e) 
                    {
                        var_dump('erreur durant la création de user :   ' . $e->getMessage());
                        $_SESSION['error_message'] = "Erreur lors de la création du compte. Veuillez réessayer.";
                        $this->redirect('inscription');
                    }
                } else {
                    var_dump('Les passwords ne match pas');
                    $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                    $this->redirect('inscription');
                }
            } else {
                var_dump('un user exsiste déjà avec cet email');
                $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse email.";
                $this->redirect('inscription');
            }
        } else {
            var_dump('Le jeton CSRF est invalide');
            $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
            $this->redirect('inscription');
        }
    } else {
        var_dump('Tous les champs sont obligatoires.');
        $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
        $this->redirect('inscription');
    }
}

    
    public function login(): void
    {
        $this->render('login.html.twig', []);
    }

    public function checkLogin() : void
    {
        if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }

        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csrf_token'])) {

            $tm = new CSRFTokenManager();

            if($tm->validateCSRFToken($_POST['csrf_token'])) {

                $user = $this->um->findUserByEmail($_POST['email']);

                if($user !== null)
                {
                    if(password_verify($_POST['password'], $user->getPassword()))
                    {
                        $_SESSION['user'] = $user;
                        $this->redirect(null);
                    }
                    else
                    {
                        $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                        $this->redirect('connexion');
                    }
                }
                else
                {
                    $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                    $this->redirect('connexion');
                }
            }
            else
            {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('connexion');
            }
        }
        else
        {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect('connexion');
        }
    }

    public function logout() : void
    {
        session_destroy();
        $this->redirect(null);
    }
}