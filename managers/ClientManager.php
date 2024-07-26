<?php 

class ClientManager extends AbstractManager 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findByEmail(string $email): ?Clients
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM clients
            WHERE email = :email"
        );
        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);
    
        if ($query->rowCount() === 1) {
            $user = $query->fetch(PDO::FETCH_ASSOC);
            
            // Vérifiez si les clés existent dans le tableau $user
            if (isset($user["id"], $user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"])) {
                $client = new Clients($user["first_name"], $user["last_name"], $user["email"], $user["phone"], $user["password"]);
                $client->setId($user["id"]);
                return $client;
            } else {
                return null; // Les données ne sont pas complètes
            }
        } else {
            return null;
        }
    }
    public function create(Clients $client): bool
    {
        $query = $this->db->prepare(
            "INSERT INTO clients (
                last_name,
                first_name,
                email,
                phone,
                password
            ) VALUES (
                :last_name,
                :first_name,
                :email,
                :phone,
                :password
            )"
        );
        $parameters = [
            'last_name' => $client->getLast_name(),
            'first_name' => $client->getFirst_name(),
            'email' => $client->getEmail(),
            'phone' => $client->getPhone(),
            'password' => password_hash($client->getPassword(), PASSWORD_DEFAULT)
        ];
        return $query->execute($parameters);
    }
public function findAll(): array
{
    $query = $this->db->prepare('SELECT * FROM clients');
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $clients = [];

    foreach ($result as $item) {
        // Vérifiez si les clés nécessaires sont présentes
        if (isset($item["id"], $item["first_name"], $item["last_name"], $item["email"], $item["phone"], $item["password"])) {
            $client = new Clients($item["first_name"], $item["last_name"], $item["email"], $item["phone"], $item["password"]);
            $client->setId($item["id"]);
            $clients[] = $client;
        } else {
            // Gestion des données manquantes
            error_log('Données client incomplètes : ' . print_r($item, true));
        }
    }

    return $clients;
}
    public function saveClient(Clients $client): bool
    {
        if ($client->getId() === null) {
            // Insertion d'un nouveau client
            $query = $this->db->prepare('INSERT INTO clients (email, password) VALUES (?, ?)');
            return $query->execute([$client->getEmail(), $client->getPassword()]);
        } else {
            // Mise à jour d'un client existant
            $query = $this->db->prepare('UPDATE clients SET email = ?, password = ? WHERE id = ?');
            return $query->execute([$client->getEmail(), $client->getPassword(), $client->getId()]);
        }
    }
}