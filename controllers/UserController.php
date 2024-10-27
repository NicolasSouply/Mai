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

    // Affiche la zone utilisateur avec les commandes
    public function userZone(): void
    {
        // Vérifie si l'utilisateur est connecté et est de type `Users`
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof Users) {
            $user = $_SESSION['user'];
            
            // Récupère les commandes de l'utilisateur
            $orders = $this->om->getOrdersByUserId($user->getId());
    
            // Rend la vue de la zone utilisateur avec l'utilisateur et ses commandes
            $this->render('user-zone.html.twig', [
                'user' => $user,
                'orders' => $orders
            ]);
        } else {
            // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
            $_SESSION['error_message'] = "Pour faire une commande à emporter vous devez vous connecter.";
            header('Location: index.php?route=connexion');
            exit();
        }
    }

    // Affiche le formulaire de création d'utilisateur
    public function create() : void {
        $this->render("admin/users/create.html.twig", []);
    }

    // Vérifie et crée un nouvel utilisateur si les données sont valides
    public function checkCreate() : void {
        unset($_SESSION['error_message'], $_SESSION['success_message']);

        // Vérifie que tous les champs requis sont présents
        if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['confirm_password'], $_POST['csrf_token'], $_POST["role"])) {

            $tm = new CSRFTokenManager();

            // Vérifie le token CSRF pour la sécurité
            if ($tm->validateCSRFToken($_POST['csrf_token'])) {

                // Vérifie si l'utilisateur existe déjà avec l'email donné
                $user = $this->um->findUserByEmail($_POST['email']);

                if ($user === null) {
                    // Vérifie la correspondance des mots de passe
                    if ($_POST['password'] === $_POST['confirm_password']) {
                        // Hache le mot de passe
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
                            // Crée l'utilisateur et enregistre un message de succès
                            $this->um->createUser($user);
                            $_SESSION['success_message'] = "L'utilisateur a bien été créé";
                            $this->redirect('admin-list-users');
                        } catch (\Exception $e) {
                            // Gestion des erreurs lors de la création de l'utilisateur
                            $_SESSION['error_message'] = $e->getMessage();
                            $this->redirect('admin-create-user');
                        }
                    } else {
                        // Message d'erreur si les mots de passe ne correspondent pas
                        $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                        $this->redirect('admin-create-user');
                    }
                } else {
                    // Message d'erreur si un utilisateur avec cet email existe déjà
                    $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse.";
                    $this->redirect('admin-create-user');
                }
            } else {
                // Message d'erreur si le jeton CSRF est invalide
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('admin-create-user');
            }
        } else {
            // Message d'erreur si tous les champs ne sont pas remplis
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect('admin-create-user');
        }
    }

    // Affiche le formulaire d'édition pour un utilisateur
    public function edit(int $id) : void {
        $user = $this->um->findUserById($id);
        $_SESSION['success_message'] = "L'utilisateur a bien été modifié.";
        $this->render("admin/users/edit.html.twig", [
            "user" => $user
        ]);
    }

    // Vérifie et applique les modifications à un utilisateur existant
    public function checkEdit(int $id) : void 
    {
        unset($_SESSION['error_message'], $_SESSION['success_message']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['confirm_password'], $_POST['csrf_token'], $_POST['role'])) {

                $tm = new CSRFTokenManager();
    
                if ($tm->validateCSRFToken($_POST['csrf_token'])) {
    
                    // Récupère l'utilisateur à modifier
                    $user = $this->um->findUserById($id);
    
                    if ($user !== null) {
                        if ($_POST['password'] === $_POST['confirm_password']) {
                            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
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
                                header('Location: index.php?route=admin-list-users');
                                exit;
    
                            } catch (Exception $e) {
                                $_SESSION['error_message'] = "Erreur lors de la mise à jour.";
                                header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                                exit;
                            }
                        } else {
                            $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                            header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                            exit;
                        }
                    } else {
                        $_SESSION['error_message'] = "Utilisateur introuvable.";
                        header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                        exit;
                    }
                } else {
                    $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                    header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                    exit;
                }
            } else {
                $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
                header('Location: index.php?route=admin-edit-user&user_id=' . urlencode($id));
                exit;
            }
        }
    }

    // Supprime un utilisateur
    public function delete(int $id) : void {
        if ($this->um->deleteUser($id)) {
            $_SESSION['success_message'] = "L'utilisateur a été supprimé";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la suppression de l'utilisateur.";
        }
        $this->redirect('admin-list-users');
    }

    // Liste tous les utilisateurs
    public function list() : void {
        $users = $this->um->findAllUsers();
        $this->render("admin/users/list.html.twig", [
            "users" => $users
        ]);
    }

    // Affiche les détails d'un utilisateur avec données sécurisées
    public function show(int $id) : void {
        unset($_SESSION['error_message'], $_SESSION['success_message']);
        $user = $this->um->findUserById($id);

        // Échappe les données de l'utilisateur pour éviter les failles XSS
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

    // Affiche les commandes d'un utilisateur dans la zone utilisateur
    public function showOrder()
    {
        $userId = $_SESSION['user']->getId();
        $orders = $this->om->getOrderById($userId);
        return $this->render('user_zone/orders.html.twig', [
            'orders' => $orders
        ]);
    }
}
