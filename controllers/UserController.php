<?php

class UserController extends AbstractController
{
    private UserManager $um;
    private OrderManager $om;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->om = new OrderManager();
    }

    public function userZone(): void
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof Users) {
            $user = $_SESSION['user'];
            
            // Récupérer les commandes de l'utilisateur
            $orders = $this->om->getOrdersByUserId($user->getId());  // Assure-toi que cette méthode existe dans ton OrderManager
    
            // Rendre la vue avec les commandes et l'utilisateur
            $this->render('user-zone.html.twig', [
                'user' => $user,
                'orders' => $orders // Passe les commandes à la vue
            ]);
        } else {
            $_SESSION['error_message'] = "Pour faire une commande à emporter vous devez vous connecter.";
            header('Location: index.php?route=connexion');
            exit();
        }
    }


    public function create() : void {
        
        $this->render("admin/users/create.html.twig", []);
    }
    public function checkCreate() : void {
        if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }

        if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) &&isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['csrf_token']) && isset($_POST["role"])) {

            $tm = new CSRFTokenManager();

            if($tm->validateCSRFToken($_POST['csrf_token'])) {

                $user = $this->um->findUserByEmail($_POST['email']);

                if($user === null)
                {
                    if($_POST['password'] === $_POST['confirm_password'])
                    {
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $user = new Users(  
                        $_POST['first_name'],
                        $_POST['last_name'],
                        $_POST['email'],
                        $_POST['phone'],
                        $password,
                        $_POST["role"]
                        );
                        
                        try {
                            $this->um->createUser($user);
                            $_SESSION['success_message'] = "L'utilisateur a bien été créé";
                            $this->redirect('admin-list-users');
                        }
                        catch(\Exception $e)
                        {
                            $_SESSION['error_message'] = $e->getMessage();
                            $this->redirect('admin-create-user');
                        }
                    }
                    else
                    {
                        $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                        $this->redirect('admin-create-user');
                    }
                }
                else
                {
                    $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse.";
                    $this->redirect('admin-create-user');
                }
            }
            else
            {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('admin-create-user');
            }
        }
        else
        {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect('admin-create-user');
        }
    }

    public function edit(int $id) : void {
        $user = $this->um->findUserById($id);
        $_SESSION['success_message'] = "L'utilisateur a bien été modifié.";
        $this->render("admin/users/edit.html.twig", [
            "user" => $user
        ]);
    }
    public function checkEdit(int $id) : void 
    {
        // Nettoyage des messages de session précédents
        unset($_SESSION['error_message'], $_SESSION['success_message']);

        // Vérifie que la requête est bien de type POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['confirm_password'], $_POST['csrf_token'], $_POST['role'])) {

                // Initialisation du gestionnaire CSRF
                $tm = new CSRFTokenManager();
    
                // Vérifie le token CSRF
                if ($tm->validateCSRFToken($_POST['csrf_token'])) {
    
                    // Récupère l'utilisateur à modifier
                    $user = $this->um->findUserById($id);
    
                    if ($user !== null) {
                        if ($_POST['password'] === $_POST['confirm_password']) {
                            // Hache le mot de passe
                            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
                            // Crée un nouvel objet `Users`
                            $user = new Users(
                                $_POST['first_name'],
                                $_POST['last_name'],
                                $_POST['email'],
                                $_POST['phone'],
                                $password,
                                $_POST['role']
                            );
                            $user->setId($id);
    
                            try {
                                $this->um->updateUser($user);
    
                                $_SESSION['success_message'] = "L'utilisateur a bien été modifié";
                                // Redirection après succès
                                header('Location: index.php?route=admin-list-users');
                                exit;
    
                            } catch (Exception $e) {
                                // Gestion des erreurs de mise à jour
                                $_SESSION['error_message'] = "Erreur lors de la mise à jour.";
                                header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                                exit;
                            }
                        } else {
                            // Si les mots de passe ne correspondent pas
                            $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                            header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                            exit;
                        }
                    } else {
                        // Si l'utilisateur n'est pas trouvé
                        $_SESSION['error_message'] = "Utilisateur introuvable.";
                        header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                        exit;
                    }
                } else {
                    // Token CSRF invalide
                    $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                    header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                    exit;
                }
            } else {
                // Si tous les champs ne sont pas remplis
                $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
                header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                exit;
            }
        }
    }

    
    public function delete(int $id) : void {
        if($this->um->deleteUser($id)) {
            $_SESSION['success_message'] = "L'utilisateur a été supprimé";
            $this->redirect('admin-list-users');
        }else {
            $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur.";
        }
        $this->redirect('admin-list-users');
    }

    public function list() : void {
        $users = $this->um->findAllUsers();

        $this->render("admin/users/list.html.twig", [
            "users" => $users
        ]);
    }

    public function show(int $id) : void {
        if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }

        $user = $this->um->findUserById($id);

            // Échappez les données de l'utilisateur
    $safeUser = [
        'first_name' => htmlspecialchars($user->getFirst_name(), ENT_QUOTES, 'UTF-8'),
        'last_name' => htmlspecialchars($user->getLast_name(), ENT_QUOTES, 'UTF-8'),
        'email' => htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8'),
        'phone' => htmlspecialchars($user->getPhone(), ENT_QUOTES, 'UTF-8'),
    ];

        $this->render("admin/users/show.html.twig", [
            "user" => $safeUser
        ]);
    }
    public function showOrder()
    {
        $userId = $_SESSION['user']->getId();
    
        // Récupérer les commandes de l'utilisateur
        $orders = $this->om->getOrderById($userId);
    
        // Passer les commandes à la vue
        return $this->render('user_zone/orders.html.twig', [
            'orders' => $orders
        ]);
    }

}
