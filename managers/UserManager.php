<?php 

class UserManager extends AbstractManager 
{
    public function __construct()
    {
        parent::__construct();
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
                $user = new Users($user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"]);
                $user->setId($user["id"]);
                return $user;
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
                $user = new Users($user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"], $user["role"]);
                $user->setId($user["id"]);
                return $user;
            } else {
                return null; // Les données ne sont pas complètes
            }
        } else {
            return null;
        }
    }
    public function create(Users $user): bool
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