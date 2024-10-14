<?php

use PHPUnit\Framework\TestCase;

require './models/Users.php'; // Assurez-vous de spécifier le bon chemin vers votre fichier Users.php

class UsersTest extends TestCase
{
    private Users $user;

    protected function setUp(): void
    {
        // Initialisation d'un utilisateur pour les tests
        $this->user = new Users(
            first_name: 'John',
            last_name: 'Doe',
            email: 'john.doe@example.com',
            phone: '1234567890',
            password: 'securepassword',
            role: 'USER'
        );
    }

    public function testGetFirstName()
    {
        $this->assertEquals('John', $this->user->getFirst_name());
    }

    public function testSetFirstName()
    {
        $this->user->setFirst_name('Jane');
        $this->assertEquals('Jane', $this->user->getFirst_name());
    }

    public function testGetLastName()
    {
        $this->assertEquals('Doe', $this->user->getLast_name());
    }

    public function testSetLastName()
    {
        $this->user->setLast_name('Smith');
        $this->assertEquals('Smith', $this->user->getLast_name());
    }

    public function testGetEmail()
    {
        $this->assertEquals('john.doe@example.com', $this->user->getEmail());
    }

    public function testSetEmail()
    {
        $this->user->setEmail('jane.doe@example.com');
        $this->assertEquals('jane.doe@example.com', $this->user->getEmail());
    }

    public function testGetPhone()
    {
        $this->assertEquals('1234567890', $this->user->getPhone());
    }

    public function testSetPhone()
    {
        $this->user->setPhone('0987654321');
        $this->assertEquals('0987654321', $this->user->getPhone());
    }

    public function testGetPassword()
    {
        $this->assertEquals('securepassword', $this->user->getPassword());
    }

    public function testSetPassword()
    {
        $this->user->setPassword('newpassword');
        $this->assertEquals('newpassword', $this->user->getPassword());
    }

    public function testGetRole()
    {
        $this->assertEquals('USER', $this->user->getRole());
    }

    public function testSetRole()
    {
        $this->user->setRole('ADMIN');
        $this->assertEquals('ADMIN', $this->user->getRole());
    }

  }
