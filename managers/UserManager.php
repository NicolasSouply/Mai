<?php 

class UserManager extends AbstractManager 
{
    public function __construct()
    {
        parent::__construct();
    }

    // Créer un nouvel utilisateur
    public function createUser(Users $user): ?Users
    {

        $query = $this->db->prepare(
            "INSERT INTO users (
            first_name,
            last_name,
            email, 
            phone,
            password, 
            role) 
            VALUES ( 
            :first_name, 
            :last_name,
            :email, 
            :phone, 
            :password, 
            :role)"
        );
        $parameters = [
            ':first_name' => $user->getFirst_name(),
            ':last_name' => $user->getLast_name(),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone(),
            ':password' => $user->getPassword(),
            ':role' => $user->getRole()
        ];
    
    // Debugging
    var_dump($parameters);  // Check values being inserted


            $query->execute($parameters);
            $user->setId($this->db->lastInsertId());
            return $user;
        
        }
    

    // Modifier un utilisateur
    public function updateUser(Users $user) : Users
    {
        $query = $this->db->prepare("UPDATE users 
            SET first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                email = :email, 
                password = :password, 
                role = :role 
            WHERE id = :id"
        );
        $parameters = [
            ':first_name' => $user->getFirst_name(),
            ':last_name' => $user->getLast_name(),
            ':phone' => $user->getPhone(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':role' => $user->getRole(),
            ':id' => $user->getId()
        ];

        $query->execute($parameters);

        return $user;
    }


    // Supprimer un utilisateur 
    public function deleteUser(int $id) : void 
    {

        $query = $this->db->prepare(
            "DELETE FROM users WHERE id = :id");
        $parameters = ['id' => $id];

        $query->execute($parameters);
        
    }

    // Rechercher un utilisateur par ID
    public function findUserById(string $id): ?Users
    {

        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $user = null;
        
        if($result)
        {

        $user = new Users(
            $result["first_name"],
            $result["last_name"],
            $result["email"],
            $result["phone"],
            $result["password"],
            $result["role"]
        );
        $user->setId($result["id"]);

        return $user;
    }
    }
    // Rechercher un utilisateur par adresse mail
    public function findUserByEmail(string $email): ?Users
    {   var_dump($email);

        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);

        $result = $query->fetch(PDO::FETCH_ASSOC);
       var_dump($result);

        $user = null;

        if($result)
        { $user = new Users(
            $result["first_name"],
            $result["last_name"],
            $result["email"],
            $result["phone"],
            $result["password"],
            $result["role"]
        );
        $user->setId($result["id"]);
    }
    
            return $user;
    }

    // Rechercher tous les utilisateurs
    public function findAllUsers(): array
    {
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $users = [];

        foreach ($result as $item) {
           
                $user = new Users($item["first_name"], $item["last_name"], $item["email"], $item["phone"], $item["password"], $item["role"]);
                $user->setId($item["id"]);
                $users[] = $user;
            } 

        return $users;
    }


}
