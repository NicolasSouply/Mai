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

        if ($query->execute($parameters)) {
            $user->setId($this->db->lastInsertId());
            return $user;
        } else {
            $errorInfo = $query->errorInfo();
            echo "Erreur lors de la création de l'utilisateur : " . implode(", ", $errorInfo);
            return null;
        }
    }
// Modifier un utilisateur
    public function updateUser(Users $user) : ?Users
    {
        $query = $this->db->prepare(
            "UPDATE users
            SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, password = :password, role = :role
            WHERE id = :id"
        );
        $parameters = [
            'last_name' => $user->getLast_name(),
            'first_name' => $user->getFirst_name(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'role' => $user->getRole()
        ];
        if ($query->execute($parameters)) {
            
            return $user;
        } else 
            {
            return null;
            }
    }


// Supprimer un utilisateur 
public function deleteUser(int $id) : void 
{
    $query = $this->db->prepare(
        "DELETE FROM users WHERE id = :id"
    );

    $parameters = [
        'id' => $id
    ];

    if (!$query->execute($parameters)) {

    }

}

    // Rechercher un utilisateur par ID
    public function findUserById(string $id): ?Users
    {
        $query = $this->db->prepare
        (
            "SELECT *
            FROM users
            WHERE id = :id"
        );
        $query->execute(['id' => $id]);
   
        $user = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($user === false) {
            return null;
        }

        $users = new Users($user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"]);
        $users->setId($user["id"]);

        return $users;
        }


        
    // Rechercher un utilisateur par adresse mail
    public function findUserByEmail(string $email): ?Users
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM users
            WHERE email = :email"
        );
        $query->execute(["email" => $email]);
    
        $user = $query->fetch(PDO::FETCH_ASSOC);
            
        if ($user === false) {
            return null;
        }
            $users = new Users($user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"]);
            $users->setId($user["id"]);

            return $users;
    }

    
// Rechercher tous les utilisateurs
public function findAllUsers(): array
{
    $query = $this->db->prepare('SELECT * FROM users');
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $users = [];

    foreach ($result as $item) {
        // Vérifiez si les clés nécessaires sont présentes
        if (isset($item["id"], $item["first_name"], $item["last_name"], $item["email"], $item["phone"], $item["password"], $item["role"])) {
            $user = new Users($item["first_name"], $item["last_name"], $item["email"], $item["phone"], $item["password"], $item["role"]);
            $user->setId($item["id"]);
            $users[] = $user;
        } else {
            // Gestion des données manquantes
            error_log('Données user incomplètes : ' . print_r($item, true));
        }
    }

    return $users;
}
    public function saveUser(Users $user): bool
    {
        if ($user->getId() === null) {
            // Insertion d'un nouveau user
            $query = $this->db->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
            return $query->execute([$user->getEmail(), $user->getPassword(), $user->getRole()]);
        } else {
            // Mise à jour d'un user existant
            $query = $this->db->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
            return $query->execute([$user->getEmail(), $user->getPassword(), $user->getRole(), $user->getId()]);
        }
    }
}