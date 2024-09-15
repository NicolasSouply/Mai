<?php

class UserController extends AbstractController
{
    private UserManager $um;
    private DisheManager $dm;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->dm = new DisheManager();
    }

    public function userZone(): void
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof Users) {
            $user = $_SESSION['user'];
            // Debug: Vérifie les données de l'utilisateur
            var_dump($user);
            $this->render('user-zone.html.twig', [
                'user' => $user
            ]);
        } else {
            $_SESSION['error_message'] = "Vous devez être connecté pour accéder à cette page.";
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

        $this->render("admin/users/edit.html.twig", [
            "user" => $user
        ]);
    }
    public function checkEdit(int $id) : void {
        if(isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if(isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }

        if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) &&isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['csrf_token']) && isset($_POST["role"])) {

            $tm = new CSRFTokenManager();

            if($tm->validateCSRFToken($_POST['csrf_token'])) {

                $user = $this->um->findUserById($id);

                if($user !== null)
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
                        $user->setId($id);

                        try {
                            $this->um->updateUser($user);
                            $_SESSION['success_message'] = "L'utilisateur a bien été modifié";
                            $this->redirect('admin-list-users');
                        }
                        catch(\Exception $e)
                        {
                            $_SESSION['error_message'] = $e->getMessage();
                            $this->redirect("admin-edit-user&user_id=$id");
                        }
                    }
                    else
                    {
                        $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                        $this->redirect("admin-edit-user&user_id=$id");
                    }
                }
                else
                {
                    $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse.";
                    $this->redirect("admin-edit-user&user_id=$id");
                }
            }
            else
            {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect("admin-edit-user&user_id=$id");
            }
        }
        else
        {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect("admin-edit-user&user_id=$id");
        }
    }
    
    public function delete(int $id) : void {
        $this->um->deleteUser($id);
        $_SESSION['success_message'] = "L'utilisateur a été supprimé";
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

        $this->render("admin/users/show.html.twig", [
            "user" => $user
        ]);
    }

}
