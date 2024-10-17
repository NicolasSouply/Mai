<?php 

class UserManager extends AbstractManager 
{
    public function __construct()
    {
        // Appel du constructeur de la classe parent (AbstractManager)
        parent::__construct();
    }

    // Créer un nouvel utilisateur
    public function createUser(Users $user): ?Users
    {
        // Préparation de la requête d'insertion d'un nouvel utilisateur
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

        // Définition des paramètres avec les données de l'objet utilisateur
        $parameters = [
            ':first_name' => $user->getFirst_name(),
            ':last_name' => $user->getLast_name(),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone(),
            ':password' => $user->getPassword(),
            ':role' => $user->getRole()
        ];

        // Exécution de la requête avec les paramètres fournis
        $query->execute($parameters);

        // Récupération de l'ID du dernier utilisateur inséré et mise à jour de l'objet utilisateur
        $user->setId($this->db->lastInsertId());

        // Retourne l'utilisateur créé
        return $user;
    }

    // Modifier un utilisateur existant
    public function updateUser(Users $user) : Users
    {
        // Préparation de la requête de mise à jour pour les informations de l'utilisateur
        $query = $this->db->prepare("UPDATE users 
            SET first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                email = :email, 
                password = :password, 
                role = :role 
            WHERE id = :id"
        );

        // Définition des paramètres de la mise à jour avec les données de l'objet utilisateur
        $parameters = [
            ':first_name' => $user->getFirst_name(),
            ':last_name' => $user->getLast_name(),
            ':phone' => $user->getPhone(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':role' => $user->getRole(),
            ':id' => $user->getId()
        ];

        // Exécution de la requête avec les paramètres fournis
        $query->execute($parameters);

        // Retourne l'utilisateur modifié
        return $user;
    }

    // Supprimer un utilisateur 
    public function deleteUser(int $id) : bool 
    {
        // Supprime d'abord les commandes associées à l'utilisateur pour maintenir l'intégrité des données
        $this->db->prepare("DELETE FROM orders WHERE user_id = :userId")->execute([':userId' => $id]);
        
        // Préparation de la requête pour supprimer l'utilisateur en fonction de son ID
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id");
        
        // Exécution de la requête de suppression et retourne vrai si la suppression a réussi
        return $query->execute(['id' => $id]);
    }

    // Rechercher un utilisateur par son ID
    public function findUserById(string $id): ?Users
    {
        // Préparation de la requête pour sélectionner un utilisateur en fonction de son ID
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id"); 

        // Exécution de la requête avec l'ID fourni en paramètre
        $parameters = ["id" => $id];
        $query->execute($parameters);

        // Récupération du résultat sous forme de tableau associatif
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // Vérifie si un utilisateur a été trouvé
        if ($result) {
            // Création de l'objet utilisateur avec les données récupérées
            $user = new Users(
                $result["first_name"],
                $result["last_name"],
                $result["email"],
                $result["phone"],
                $result["password"],
                $result["role"]
            );
            $user->setId($result["id"]);

            // Retourne l'utilisateur trouvé
            return $user;
        }

        // Retourne null si aucun utilisateur n'a été trouvé
        return null;
    }

    // Rechercher un utilisateur par son adresse email
    public function findUserByEmail(string $email): ?Users
    {   
        // Préparation de la requête pour sélectionner un utilisateur en fonction de son adresse email
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");

        // Exécution de la requête avec l'email fourni en paramètre
        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);

        // Récupération du résultat sous forme de tableau associatif
        $result = $query->fetch(PDO::FETCH_ASSOC);
       
        // Initialisation de l'objet utilisateur
        $user = null;

        // Si un utilisateur a été trouvé, création de l'objet avec les données récupérées
        if ($result) {
            $user = new Users(
                $result["first_name"],
                $result["last_name"],
                $result["email"],
                $result["phone"],
                $result["password"],
                $result["role"]
            );
            $user->setId($result["id"]);
        }
    
        // Retourne l'utilisateur trouvé ou null si aucun utilisateur n'a été trouvé
        return $user;
    }

    // Rechercher tous les utilisateurs
    public function findAllUsers(): array
    {
        // Préparation de la requête pour sélectionner tous les utilisateurs
        $query = $this->db->prepare('SELECT * FROM users');
        
        // Exécution de la requête
        $query->execute();

        // Récupération de tous les résultats sous forme de tableau associatif
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Initialisation d'un tableau pour stocker les objets utilisateur
        $users = [];

        // Parcours des résultats et création d'un objet utilisateur pour chaque enregistrement
        foreach ($result as $item) {
            $user = new Users(
                $item["first_name"], 
                $item["last_name"], 
                $item["email"], 
                $item["phone"], 
                $item["password"], 
                $item["role"]
            );
            $user->setId($item["id"]);
            
            // Ajoute l'utilisateur au tableau
            $users[] = $user;
        }

        // Retourne le tableau d'utilisateurs
        return $users;
    }
}