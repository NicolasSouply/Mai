<?php

class AdminManager extends AbstractManager 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function isAdmin(string $email): bool
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM admin WHERE email = :email");
        $parameters = ["email" => $email ];
        $query->execute($parameters);
        return $query->fetchColumn() > 0;
    }
}
