<?php

class AdminController extends AbstractController
{private AdminManager $am;
private DisheManager $dm;
private UserManager $um;


  public function __construct()
  {
      parent::__construct();
      $this->am = new AdminManager();
      $this->dm = new DisheManager();
      $this->um = new UserManager();
  }
 
  public function home() : void {
    $this->render('admin/home.html.twig', []);
}


public function checkCreate() : void {
    if(isset($_SESSION['error_message'])) {
        unset($_SESSION['error_message']);
    }

    if(isset($_SESSION['success_message'])) {
        unset($_SESSION['success_message']);
    }

    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['csrf_token']) && isset($_POST["role"])) {
        // Debugging: Afficher les données POST
        var_dump($_POST);

        $tm = new CSRFTokenManager();

        if($tm->validateCSRFToken($_POST['csrf_token'])) {
            $user = $this->um->findUserByEmail($_POST['email']);

            if($user === null) {
                if($_POST['password'] === $_POST['confirm_password']) {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $user = new Users($_POST['first_name'], $_POST['last_name'], $_POST['phone'], $_POST['email'], $password, $_POST["role"]);

                    // Debugging: Afficher l'objet utilisateur
                    var_dump($user);

                    try {
                        $this->um->createUser($user);
                        $_SESSION['success_message'] = "L'utilisateur a bien été créé";
                        $this->redirect('admin-list-users');
                    }
                    catch(\Exception $e) {
                        $_SESSION['error_message'] = $e->getMessage();
                        $this->redirect('admin-create-user');
                    }
                } else {
                    $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                    $this->redirect('admin-create-user');
                }
            } else {
                $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse.";
                $this->redirect('admin-create-user');
            }
        } else {
            $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
            $this->redirect('admin-create-user');
        }
    } else {
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

    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['csrf_token']) && isset($_POST["role"])) {

        $tm = new CSRFTokenManager();

        if($tm->validateCSRFToken($_POST['csrf_token'])) {

            $user = $this->um->findUserById($id);

            if($user !== null)
            {
                if($_POST['password'] === $_POST['confirm_password'])
                {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $user = new Users($_POST['first-name'], $_POST['last_name'], $_POST['phone'], $_POST['email'], $password, $_POST["role"]);
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

    public function adminZone(): void
    {
     
        if (!isset($_SESSION['user']) || $_SESSION['user']->getRole() !== 'admin') {
            $this->redirect('index.php?route=connexion');
            return;
        }

 
        $this->render('admin_zone.html.twig', []);


    }
    public function admin(): void
    {
      $this->render('admin_zone.html.twig', []);
    }

    public function findByEmail(string $email): ?Users
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM users
            WHERE email = :email"
        );
        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);
    
        if ($query->rowCount() === 1) {
            $user = $query->fetch(PDO::FETCH_ASSOC);
            
            if (isset($user["id"], $user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"])) {
                $userClass = new Users($user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"]);
                $userClass->setId($user["id"]);
                return $userClass;
            } else {
                return null; 
            }
        } else {
            return null;
        }
    }

    public function findById(string $id): ?Users
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM users
            WHERE id = :id"
        );
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
    
        if ($query->rowCount() === 1) {
            $user = $query->fetch(PDO::FETCH_ASSOC);
            if (isset($user["id"], 
                    $user["first_name"], 
                    $user["last_name"], 
                    $user["email"], 
                    $user["phone"], 
                    $user["password"], 
                    $user["role"])) 
                    {
                $userClass = new Users($user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"]);
                $userClass->setId($user["id"]);
                return $userClass;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function create(Users $user): bool
    {
        $query = $this->db->prepare(
            "INSERT INTO Users (
                last_name,
                first_name,
                email,
                phone,
                password,
                role
            ) VALUES (
                :last_name,
                :first_name,
                :email,
                :phone,
                :password,
                :role
            )"
        );
        $parameters = [
            'last_name' => $user->getLast_name(),
            'first_name' => $user->getFirst_name(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'role' => $user->getRole()
        ];
        return $query->execute($parameters);
    }

    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($result as $item) {
            if (isset($users["id"], $users["first_name"], $users["last_name"], $users["email"], $users["phone"], $users["password"], $users["role"])) {
                $usersClass = new Users($users["first_name"], $users["last_name"], $users["email"], $users["phone"], $users["password"], $users["role"]);
                $usersClass->setId($users["id"]);
                return $users;
            } else {
                error_log('Données user incomplètes : ' . print_r($item, true));
            }
        }

        return $users;
    }

    public function saveUser(Users $user): bool
    {
        if ($user->getId() === null) {
            $query = $this->db->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
            return $query->execute([$user->getEmail(), $user->getPassword()]);
        } else {
            $query = $this->db->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
            return $query->execute([$user->getEmail(), $user->getPassword(), $user->getId()]);
        }
    }

    public function modifyUser():void{
      $query = $this->db->prepare(
          "UPDATE users
          SET last_name = :last_name,
          first_name = :first_name,
          email = :email,
          ADMIN = :ADMIN
          WHERE id = :id"
      );

      $parameters = [
          "last_name"=>$_POST["last_name"],
          "first_name"=>$_POST["first_name"],
          "email"=>$_POST["email"],
          "ADMIN" =>$_POST["ADMIN"],
          "id"=>$_POST["user-id"]
      ];

      $query->execute($parameters);
  }
  public function deleteuser(string $email): void
  {
      $user = $this->findByEmail($email);
      if ($user) {
          $id = $user->getId();
          

          $query = $this->db->prepare(           // Suppression par id
              "DELETE FROM users
              WHERE user_id = :id"
          );
          $parameters = [
              "id" => $id
          ];
          $query->execute($parameters);
          

          $query = $this->db->prepare(          // Suppression par email
              "DELETE FROM users
              WHERE email = :email"
          );
          $parameters = [
              "email" => $email
          ];
          $query->execute($parameters);
      } else {
          throw new Exception("Le user avec l'email :  $email n'a pas été trouvé.");
      }
  }
}