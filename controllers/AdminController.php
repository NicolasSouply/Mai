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
    public function adminZone(): void
    {
     
        if (!isset($_SESSION["admin"])) {
            $this->redirect("index.php?route=connexion"); 
            return;
        }

 
        $admin = $_SESSION["admin"];


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
                role
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
                return $usersClass;
            } else {
                error_log('Données user incomplètes : ' . print_r($item, true));
            }
        }

        return $users;
    }

    public function saveuser(Users $user): bool
    {
        if ($user->getId() === null) {
            $query = $this->db->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
            return $query->execute([$user->getEmail(), $user->getPassword()]);
        } else {
            $query = $this->db->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
            return $query->execute([$user->getEmail(), $user->getPassword(), $user->getId()]);
        }
    }

    public function modifyuser():void{
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